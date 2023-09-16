<?php
    $githubToken = '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';
    $repoOwner = 'clinicarehn';
    $repoName = 'devizzy';

    $apiUrl = "https://api.github.com/repos/$repoOwner/$repoName/releases/latest";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: token $githubToken"]);
    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);

    if (isset($data['tag_name'])) {
        echo $data['tag_name'];
    } else {
        //echo "No se pudo obtener la versión.";
        echo "Versión: 2.0.0.9";
    }
?>