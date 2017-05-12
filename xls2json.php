<?php

require __DIR__ . "/vendor/autoload.php";

class Xls2Json {

    const MAP_MODE = 1; //transform to map format
    const ARR_MODE = 2; //tranform to array format
    /**
    * process xls file to json array
    */
    public static function process($xlsFile, $mode = self::MAP_MODE) {
        $reader = new SpreadsheetReader($xlsFile);
        $sheets = $reader->Sheets();
        $data = [];
        foreach ($sheets as $index => $title) {
            $info = self::extractSheetData($reader, $index, $mode);
            if (!$info) continue;

            if ($mode == self::MAP_MODE) {
                $data[$title] = $info;
            } else {
                $sheetData = ["title" => $title];
                $sheetData['data'] = $info;
                $data[$index] = $sheetData;
            }
        }
        return $data;
    }

    private static function getSheetValidRange($reader) {
        $row = [];
        foreach ($reader as $row) {
            break;
        }
        $left = 0;
        $right = count($row) - 1;
        while (!$row[$left]) $left++;
        while (!$row[$right]) $right--;
        if ($left > $right) {
            return false;
        }
        return [$left, $right];
    }

    private static function extractMapSheetData($reader, $li, $ri) {
        $colArr = [];
        foreach ($reader as $row) {
            if (!self::isValid($row)) continue;
            for ($i = $li; $i <= $ri; $i++) {
                if (!isset($colArr[$i])) {
                    $colArr[$i] = [];
                }
                $colArr[$i][] = isset($row[$i]) ? $row[$i] : '';
            }
            
        }
        $map = [];
        foreach ($colArr as $list) {
            $key = array_shift($list);
            $map[$key] = $list;
        }
        return $map;
    }

    private static function extractArrSheetData($reader, $li, $ri) {
        $data = [];
        $n = $ri - $li + 1;
        foreach ($reader as $row) {
            if (!self::isValid($row)) continue;
            $data[] = array_slice($row, $li, $n);
        }
        return $data;
    }

    private static function extractSheetData($reader, $index, $mode) {
        $reader->ChangeSheet($index);
        $data = [];
        $range = self::getSheetValidRange($reader);
        if (!$range) {
            return false;
        }
        list($li, $ri) = $range;
        $reader->rewind(); //read from first
        if ($mode == self::MAP_MODE) {
            return self::extractMapSheetData($reader, $li, $ri);
        }
        return self::extractArrSheetData($reader, $li, $ri);
    }

    private static function isValid($row) {
        foreach ($row as $v) {
            if ($v) {
                return true;
            }
        }
        return false;
    }
}