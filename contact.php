<?php
//Initialisation des variables//
$message_envoye = false;
$erreur = '';

//traitement du formulaire//

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //recuperation et nettoyage des données
    $nom = htmlspecialchars(trim($_POST['nom'] ?? ''));
    $email = htmlspecialchars(trim($_POST['email'] ?? ''));
    $message = htmlspecialchars(trim($_POST['message'] ?? ''));

    //validation
    if (empty($nom) || empty($email) || empty($message)) {
        $erreur = "Tous les champs sont obligatoires.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreur = "L'adresse email n'est pas valide.";
    } else {
        //envoie de l'email (simulation en local)
        $destinataire = "celine.ferrieres@outlook.fr";
        $sujet = "Nouveau message depuis le site Art'Bustes du Jardin" . $nom;
        $contenu = "Nom :$nom\n";
        $contenu .= "Email : $email\n\n";
        $contenu .= "Message :\n$message";

        // en local : sauvegarder dans un fichier
        $fichier_message = 'message_contact.txt';
        $log = "n\n==========" . date('d/m/Y H:i:s') . "==========\n";
        $log .= "De : $nom($email)\n";
        $log .= "Message :\n$message\n";

        if (file_put_contents($fichier_message, $log, FILE_APPEND)) {
            $message_envoye = true;
        } else {
            $erreur = "Erreur lors de l'envoi.Veuillez réessayer.";
        }

        /* quand le site sera en ligne
        $header = "From : $email\r\n";
        $header .= "Reply-To: $email\r\n";

        if (mail($destinataire, $sujet, $contenu, $header)) {
            $message_envoye = true;
        } else {
            $erreur = "Erreur lors de l'envoi. Veuillez réessayer";*/
    }
}


include 'includes/header.php';
?>

<main>

    <h2 class="contact">Contactez-nous</h2>

    <?php if ($message_envoye): ?>

        <div class="message-succes">
            Votre message a bien été envoyé ! Nous vous répondrons dans les plus brefs délais.
        </div>

    <?php endif; ?>


    <?php if ($erreur): ?>

        <div class="message-erreur">
            <?= $erreur; ?>
        </div>

    <?php endif; ?>


    <form method="post" action="" class="formulaire-contact">

        <label for="nom">Nom</label>
        <input type="text" id="nom" name="nom" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>

        <label for="message">Votre message</label>
        <textarea id="message" name="message" required></textarea>

        <button type="submit" class="btn">Envoyer</button>

    </form>

    <section class="coordonnees-detail">
        <h3>Nos coordonnées</h3>

        <div class="info-contact">
            <p><i class="fas fa-map-marker-alt"></i><strong>Adresse :</strong><br>
                Rue des Hauts Buissons<br>
                28100 DREUX<br>
                Centre Val de Loire, FRANCE</p>

            <p><i class="fas fa-phone"></i><strong>Téléphone :</strong><br>
                06 63 71 66 33<br>
                <i class="fas fa-envelope"></i><strong>Email :</strong><br>
                karine@art-bustes.fr
            </p>

            <p><i class="fas fa-clock"></i></i><strong>Horaires :</strong><br>
                Du lundi au vendredi : 9h - 18h<br>
                Sur rendez-vous</p>
        </div>
    </section>
    <div class="carte-maps">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2630.6560143499178!2d1.330660576671308!3d48.75026737131769!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e155ab66298ddd%3A0xd6d71656bab14276!2sRue%20des%20Hauts%20Buissons%2C%2028100%20Dreux!5e0!3m2!1sfr!2sfr!4v1772191937410!5m2!1sfr!2sfr"
            width="600"
            height="450"
            style="border:0;"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </div>


</main>
<?php include 'includes/footer.php'; ?>