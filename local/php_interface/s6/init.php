<?
//AddEventHandler("main", "OnBeforeProlog", "myMock", 50);

function myMock(): void
{
   global $USER;
   if(!is_object($USER)){
      $USER = new CUser();
   }
   if (!$USER->IsAdmin()){
      include($_SERVER["DOCUMENT_ROOT"] . "/coming-soon/site_closed.php");
      die();
   }
}
