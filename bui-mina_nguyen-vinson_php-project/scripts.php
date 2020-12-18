<?php

// ****     REMEMBER TO NOT FORGET TO ADD $_GET query string!!! tomorrow....

// BASICS

session_start();

$studentnumber = "";
$firstname = "";
$lastname = "";


// ------------------------- SORT BY ID ---------------------------

// sql queries go here


// ---------------------- SORT BY FIRST NAME ----------------------

// sql queries go here


// ---------------------- SORT BY LAST NAME -----------------------

// sql queries go here


// ---------------------- *INSERTION QUERY* -------------------------

// WAS FORM FILLED OUT CORRECTLY?

// was the form filled out correctly?
// !!! protect against SQL injection attacks !!!
// if not, send back to index.php
// if so, run INSERT query

// INSERT QUERY



// did the INSERTION succeed or not? (use session to remember)
// if so, display positive feedback, such as: “A new record has been added to the table”
// if so, send back to index.php

// if not, display messages, eg: “The record could not be added as requested.”


// ---------------------- *DELETION QUERY* -------------------------

// WAS FORM FILLED OUT CORRECTLY?

// was the form filled out correctly?
// !!! protect against SQL injection attacks !!!
// if not, send back to index.php
// if so, run DELETE query

// DELETE QUERY



// did the DELETION succeed or not? (use session to remember)
// if so, display feedback, such as: “A record has been deleted from the table”
// if so, send back to index.php

// if not, display messages, eg: “The record could not be deleted as requested.”


// ---------------------- *UPDATE QUERY* -------------------------

// WAS FORM FILLED OUT CORRECTLY?

// was the form filled out correctly?
// !!! protect against SQL injection attacks !!!
// if not, send back to index.php
// if so, run UPDATE query

// UPDATE QUERY



// did the UPDATE succeed or not? (use session to remember)
// if so, display feedback, such as: “A record has been updated in the table”
// if so, send back to index.php

// if not, display messages, eg: “The record could not be updated as requested.”

?>