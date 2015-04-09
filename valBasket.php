<?php include 'template/header.php'; ?>
<?php include 'model/bootstrap.php'; ?>
<?php include 'template/menu.php'; ?>
<?php include './functions/connection_db.php'; ?>
<?php include 'template/categories.php'; ?>
<br />
<?php
$sql = "SELECT * FROM config";
$resultat = $db->query($sql);
$resultat->execute();
$reqInformation = $resultat->fetchAll(PDO::FETCH_OBJ);
foreach ($reqInformation as $value):
    $reqInterface[$value->label] = $value->value;
endforeach;
?>

<div class="container" style="min-height: 700px;">
    <h1>Votre commande</h1>
    <div class="jumbotron">
        <?php $name_from = $reqInterface['nameFo']; ?>
        <?php $email_from = $reqInterface['emailSend']; ?>
        <?php foreach ($_SESSION['panier']['article'] as $id_basket_product): ?>
            <?php $r_basket_products = getAllArticlesByAvailableId($db, $id_basket_product); ?>
            <?php while ($r_basket_product = $r_basket_products->fetch(PDO::FETCH_OBJ)) { ?>
                <?php $name_to_buy = $r_basket_product->custName . " " . $r_basket_product->custFirstName; ?>
                <?php $subject_buy = "Vente de votre article : " . $r_basket_product->artName . " - €" . $r_basket_product->price; ?>
                <?php $body_buy = "Bonjour, <br /><br />"; ?>
                <?php $body_buy .= "Un acheteur a été trouvé pour votre article : <br />"; ?>
                <?php $body_buy .= "Acheteur : " . $_SESSION['customer']['name'] . " " . $_SESSION['customer']['firstName'] . " - " . $_SESSION['customer']['email'] . "<br />"; ?>
                <?php $body_buy .= $r_basket_product->artName . " - €" . $r_basket_product->price . "<br />"; ?>
                <?php $body_buy .= "<br />Cordialement, "; ?>
                <?php $body_buy .= "<br /><br />L'équipe " . $name_from . "."; ?>
                <?php sendMailTo($name_from, $email_from, $name_to_buy, $r_basket_product->email, $subject_buy, $body_buy); ?>
            <?php } ?> 
        <?php endforeach; ?>
        
        <?php $name_to_sell = $_SESSION['customer']['email']; ?>
        <?php $subject_sell = "Confirmation de vos achats"; ?>
        <?php $body_sell = "Bonjour, <br /><br />"; ?>
        <?php $body_sell .= "Votre panier est validé, voici un récapitulatif : <br />"; ?>
        <?php $body_sell .= "Vendeur : " . $_SESSION['customer']['name'] . " " . $_SESSION['customer']['firstName'] . " - " . $_SESSION['customer']['email'] . "<br />"; ?>
        <?php $body_sell .= "<br />Cordialement, "; ?>
        <?php $body_sell .= "<br /><br />L'équipe " . $name_from . "."; ?>
        <?php sendMailTo($name_from, $email_from, $name_to_sell, $r_basket_product->email, $subject_sell, $body_sell); ?>
        Votre commande a été validée. Un mail de confirmation vous a été envoyé ainsi qu'aux vendeurs des articles.
    </div>
</div>
<?php include 'template/footer.php'; ?>