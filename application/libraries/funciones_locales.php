<?php

class FuncionesLocales
{
    public function __construct()
    {
        // Constructor code here
    }

    // Add your methods here

    // create a function that returns a date string based on a given date
    /**
     * Returns a formatted date string based on the provided date.
     *
     * @param string $tfecha The date in 'Y-m-d' format.
     * @return string Formatted date string.
     */ 
    public function getdate($tfecha)
    {
        // Check if the date is valid
        if (DateTime::createFromFormat('Y-m-d', $tfecha) === false) {
            return "Invalid date format. Please use 'Y-m-d'.";
        }

        // Create a DateTime object from the provided date
        $date = new DateTime($tfecha);

        // Return the formatted date string
        return $date->format('d/m/Y');
    }


    
}