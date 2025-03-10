<?php

namespace App\Core;

class View
{
    public static function render(string $template, array $data = [])
    {
        // Convertir chaque clé du tableau $data en variable locale
        extract($data);

        // Chemin du fichier de vue
        $viewFile = __DIR__ . "/views/{$template}.html";
        if (!file_exists($viewFile)) {
            throw new \Exception("Vue {$template} introuvable");
        }

        // On lit le contenu du fichier de vue
        $content = file_get_contents($viewFile);

        // (Optionnel) Si on a des placeholders {{var}}, on peut les remplacer par les variables
        // Par exemple :
        // foreach($data as $key => $value) {
        //    $content = str_replace("{{".$key."}}", $value, $content);
        // }

        // Afficher le contenu de la vue assemblée
        echo $content;
    }
}
