<?php

/* ---------------- REQUETE POUR SELECTIONNER LES CATEGORIES ---------------- */
$sql = "SELECT C1.id, C1.name, "
    . "(SELECT C2.name FROM category as C2 WHERE C2.id = C1.idParent) AS nameParent, "
    . "(SELECT COUNT(id) FROM category as C2 WHERE C2.idParent = C1.id) AS nbChild "
    . "FROM category as C1 "
    . "WHERE C1.isActive=0 "
    . "ORDER BY nameParent ASC,C1.name ASC ";
$resultat = $db->query($sql);
$resultat->execute();
$reqInactive = $resultat->fetchAll(PDO::FETCH_ASSOC);
$resultat->closeCursor();

?>