<?php

namespace App\SpreadSheets;


interface SpreadSheetInterface
{
    /**
     * Export a collection to a new Spreadsheet
     * @param object  $export
     * @param string  $title
     * @return string spreadsheetId
     */
    public function export($export, string $title);


    /**
     * Import a collection from a spreadsheet
     * TO BE ADDED
     * @param object  $export
     * @param string  $title
     * @return string spreadsheetId
     */
    // public function import();

    /**
     * Create a new empty spreadsheet
     * @param string  $title
     * @return object spreadsheet
     */
    public function create(string $title);
}
