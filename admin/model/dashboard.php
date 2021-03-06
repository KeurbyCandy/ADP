<?php
include_once '../functions/connection_db.php';



$monday = date('Y-m-d', strtotime('monday this week', strtotime('last sunday'))).' 00:00:00';

$sql = "SELECT "
    . "(SELECT COUNT(id) FROM article) AS articleTotal, "
    . "(SELECT COUNT(id) FROM article WHERE isActive = 1) AS articleActif, "
    . "(SELECT COUNT(id) FROM article WHERE isActive = 2) AS articleEnAttente, "
    . "(SELECT COUNT(id) FROM article WHERE isActive = 0) AS articleInactif, "
        
    . "(SELECT COUNT(id) FROM article WHERE isActive <> 0 "
        . "AND idDescription IS NOT NULL) AS articleDescription, "
    . "(SELECT COUNT(id) FROM article AS A1 WHERE isActive <> 0 "
        . "AND idDescription IS NULL "
        . "AND (SELECT COUNT(D1.id) FROM description AS D1 WHERE D1.idArticle = A1.Id AND D1.isActive=1) > 0"
        . ") AS articleDescriptionDispo, "
    . "(SELECT COUNT(id) FROM article AS A1 WHERE isActive <> 0 "
        . "AND idDescription IS NULL "
        . "AND (SELECT COUNT(id) FROM description AS D1 WHERE D1.idArticle = A1.Id AND D1.isActive=1) = 0"
        . ") AS articleDescriptionNoDispo, "
        
    . "(SELECT COUNT(id) FROM customer) AS customerTotal, "
    . "(SELECT COUNT(id) FROM customer WHERE isActive = 1) AS customerActif, "
    . "(SELECT COUNT(id) FROM customer WHERE isActive = 0) AS customerInactif, "
     
    . "(SELECT COUNT(id) FROM contact) AS contactTotal, "
    . "(SELECT COUNT(id) FROM contact WHERE status = 2) AS contactClose, "
    . "(SELECT COUNT(id) FROM contact WHERE status = 1) AS contactOpen, "
    . "(SELECT COUNT(id) FROM contact WHERE status = 0) AS contact, "

    . "(SELECT COUNT(id) FROM availability WHERE status = 2 "
            . "AND DateChange > '".$monday."') AS nbCommand ";

 
$resultat = $db->query($sql);
$resultat->execute();
$reqDashboard = $resultat->fetch(PDO::FETCH_ASSOC);
$resultat->closeCursor();

if($reqDashboard['contactClose']>0):
    $reqDashboard['ct'] = $reqDashboard['contactClose']/$reqDashboard['contactTotal']*100;
else:
    $reqDashboard['ct'] = 0;
endif;