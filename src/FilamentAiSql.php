<?php

namespace Triptasoft\FilamentAiSql;

use Filament\Widgets\Widget;
use Gemini;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;

class FilamentAiSql extends Widget
{
    protected static string $view = 'filament-ai-sql::filament-ai-sql';

    protected static ?int $sort = 2;

    public $query = '';

    public $response = '';

    public $gemini = '';

    public $sql = '';

    public function submit()
    {
        $this->response = '';
        // Validate the query input
        $validator = Validator::make(
            ['query' => $this->query],
            ['query' => 'required|string']
        );

        if ($validator->fails()) {
            $this->response = 'Query is required.';

            return;
        }

        // Use AskDatabase to execute the query
        try {
            $databaseSchema = Cache::remember('database_schema', now()->addDay(), function () {
                return $this->getDatabaseSchema(); // Implement this method to load your schema structure
            });

            $query = $this->query;

            // Adjust Gemini prompt to ensure SQL output
            $geminiPrompt = "Generate a SQL query based on the following database schema:\n\n"
                . json_encode($databaseSchema)
                . "\n\nQuery: " . $query
                . "\n\nOutput the result in SQL format.";

            // Call Gemini to generate the SQL content
            $ApiKey = config('filament-ai-sql.gemini_api_key');
            $client = Gemini::client($ApiKey);

            $gemini = $client->geminiPro()->generateContent($geminiPrompt);
            $this->gemini = $gemini->text();
            $query = str_replace(['```sql', '```'], '', $gemini->text());

            // Retrieve allowed SQL functions from the config
            $allowedFunctions = config('filament-ai-sql.allowed_sql_functions', []);

            // Check if the query contains only allowed SQL functions
            $containsAllowedFunction = false;
            foreach ($allowedFunctions as $function) {
                if (stripos(strtolower($query), $function) !== false) {
                    $containsAllowedFunction = true;

                    break;
                }
            }

            // If the query doesn't contain any allowed SQL functions, throw an exception
            if (! $containsAllowedFunction) {
                // throw new \Exception("The query contains SQL functions that are not allowed. Allowed functions are: " . implode(', ', $allowedFunctions));
                throw new \Exception('Forbidden query detected');
            }

            $sql = DB::select($query);
            $this->sql = $query;

            $jsonData = json_encode($sql, JSON_PRETTY_PRINT);
            $arrayData = json_decode($jsonData, true);

            $data = '';
            $totalItems = count($arrayData);
            // Loop through each item
            foreach ($arrayData as $index => $item) {
                // Loop through each key-value pair
                foreach ($item as $key => $value) {
                    // Append each formatted line to the response property
                    $data .= ucfirst(str_replace('_', ' ', $key)) . ' : ' . $value . '<br>';
                }
                // Add separator between teams for clarity

                if ($totalItems > 1 && $index < $totalItems - 1) {
                    $data .= '-------------------------------' . '<br>';
                }
            }

            $this->response = $data;
            // $this->response = json_encode($sql, JSON_PRETTY_PRINT);
        } catch (\Exception $e) {
            $this->response = 'Error: ' . $e->getMessage();
        }
    }

    public function getDatabaseSchema()
    {
        $schema = [];

        // Get all table names in the database
        $tables = DB::connection()->getDoctrineSchemaManager()->listTableNames();

        foreach ($tables as $table) {
            // Get columns for each table
            $columns = Schema::getColumnListing($table);

            // Get the column details
            $columnDetails = [];
            foreach ($columns as $column) {
                $columnDetails[$column] = DB::connection()
                    ->getDoctrineColumn($table, $column)
                    ->toArray();
            }

            // Add table and columns to schema array
            $schema[$table] = $columnDetails;
        }

        return $schema;
    }
}
