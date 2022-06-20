<?php

function successResponse(string $message = 'operation successful'): void
{
    session()->flash('success', $message);
}

function errorResponse(string $message = 'something went wrong'): void
{
    session()->flash('error', $message);
}

function readContents($file): \Generator
{
    while (!feof($file)) if ($row = fgetcsv($file)) yield $row;
}
