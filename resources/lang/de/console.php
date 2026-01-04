<?php

return [
    'adminUsers' => [
        'task' => [
            'label' => 'Was willst du tun?',
            'add' => 'Neuen Benutzer hinzufügen',
            'list' => 'Alle Benutzer auflisten',
            'remove' => 'Benutzer löschen',
            'exit' => 'Benutzerverwaltung beenden',
        ],

        'add' => [
            'title' => 'Neuen Benutzer hinzufügen',
            'email' => 'Email-Adresse',
            'password' => 'Passwort',
            'passwordConfirmation' => 'Passwort wiederholen',
            'passwordConfirmationFailed' => 'Die Passwörter stimmen nicht überein',
            'confirm' => [
                'label' => 'Benutzer mit Email-Adresse :email jetzt erstellen?',
                'yes' => 'Ja, speichern',
                'no' => 'Nein, abbrechen',
            ],
            'success' => 'Der Benutzer mit der Email-Adresse :email wurde erstellt',
            'error' => 'Der Benutzer konnte nicht erstellt werden.',
            'aborted' => 'Der Benutzer wurde nicht erstellt.'
        ],
        'list' => [
            'title' => 'Liste aller Benutzer',
            'email' => 'Email-Adresse',
            'created_at' => 'Erstellungsdatum',
        ],
        'remove' => [
            'title' => 'Benutzer löschen',
            'select' => 'Benutzer auswählen',
            'confirm' => '{1} Soll der Benutzer wirklich gelöscht werden?|[2,*] Sollen die :count Benutzer wirklich gelöscht werden?',
            'noneRemoved' => 'Es wurden keine Benutzer gelöscht.',
            'removed' => '{1} Der Benutzer wurde gelöscht.|[2,*] Die :count Benutzer wurden gelöscht.',
        ],
    ],
];