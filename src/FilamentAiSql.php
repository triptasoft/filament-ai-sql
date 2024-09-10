<?php

namespace Triptasoft\FilamentAiSql;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Validator;
use Gemini\Laravel\Facades\Gemini;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class FilamentAiSql extends Widget {

    protected static string $view = 'filament-ai-sql::filament-ai-sql';

    public $query = '';
    public $response = '';
    public $isLoading = false;
    public $gemini = '';

    public function submit()
    {
        $this->isLoading = true;
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
            // $gemini = Gemini::geminiPro()->generateContent($this->query);

            $databaseSchema = $this->getDatabaseSchema(); // Implement this method to load your schema structure
            $query = $this->query;

            // Adjust Gemini prompt to ensure SQL output
            $geminiPrompt = "Generate a SQL query based on the following database schema:\n\n"
                . json_encode($databaseSchema)
                . "\n\nQuery: " . $query
                . "\n\nOutput the result in SQL format.";

            // Call Gemini to generate the SQL content
            $gemini = Gemini::geminiPro()->generateContent($geminiPrompt);
            $this->gemini = $gemini->text();
            // $this->response = $gemini->text();
            $query = str_replace(['```sql', '```'], '', $gemini->text());

            $sql = DB::select($query);

            $this->response = json_encode($sql, JSON_PRETTY_PRINT);
        } catch (\Exception $e) {
            $this->response = 'Error: ' . $e->getMessage();
        }

        // $this->isLoading = false;
    }

    function getDatabaseSchema()
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
