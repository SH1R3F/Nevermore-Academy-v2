<?php

namespace App\SpreadSheets;

use Google\Client;
use RuntimeException;
use App\SpreadSheets\SpreadSheetInterface;

class GoogleSheet implements SpreadSheetInterface
{

    private $client;

    public function __construct(array $config)
    {
        $this->client = new Client();
        $this->client->setApplicationName('Google sheets api integration');
        $this->client->setAuthConfig($config);
    }

    /**
     * Export a collection to a new Spreadsheet
     * @param object  $export
     * @param string  $title
     * @return string spreadsheetId
     */
    public function export($export, string $title)
    {
        // Create a spreadsheet
        $spreadsheet = $this->create($title);

        $this->client->addScope(\Google_Service_Sheets::DRIVE);
        $service = new \Google_Service_Sheets($this->client);
        try {
            $body = new \Google_Service_Sheets_ValueRange([
                'values' => array_merge(
                    // Heading row
                    [$export->headings()],

                    // Data
                    $export->collection()->map(fn ($resource) => $export->map($resource))->toArray()
                ),
            ]);
            $result = $service->spreadsheets_values->update(
                $spreadsheet->spreadsheetId,
                'A1',
                $body,
                ['valueInputOption' => 'RAW']
            );
            return $spreadsheet->spreadsheetUrl;
        } catch (Exception $e) {
            throw new RuntimeException($e->getMessage());
        }
    }


    /**
     * Create a new empty spreadsheet
     * @param string  $title
     * @return object spreadsheet
     */
    public function create(string $title)
    {
        $this->client->addScope(\Google_Service_Sheets::SPREADSHEETS);
        $service = new \Google_Service_Sheets($this->client);
        try {
            $requestBody = new \Google_Service_Sheets_Spreadsheet([
                'properties' => ['title' => $title]
            ]);

            $response = $service->spreadsheets->create($requestBody, [
                'fields' => 'spreadsheetId,spreadsheetUrl',
            ]);

            // Set permission to public
            $this->setPermissionPublic($response->spreadsheetId);

            return $response;
        } catch (\Exception $e) {
            throw new RuntimeException($e->getMessage());
        }
    }

    /**
     * @param string  $id
     * Set permission to public
     */
    private function setPermissionPublic(string $id)
    {
        $this->client->addScope(\Google_Service_Sheets::DRIVE);
        $permission = new \Google_Service_Drive_Permission();
        $permission->setType('anyone');
        $permission->setRole('writer');
        try {
            $service = new \Google_Service_Drive($this->client);
            return $service->permissions->create($id, $permission);
        } catch (Exception $e) {
            throw new RuntimeException($e->getMessage());
        }
    }
}
