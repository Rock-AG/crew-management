@extends('layout.app', [
    'includeHeader' => true,
    'pageTitle' => __('imprint.pageTitle'),
])

@section('body')
    <div class="max-w-full md:max-w-3/4 lg:max-w-1/2 mx-2 mb-4 flex-1">

        {{-- Imprint --}}
        <h2 class="section-header mb-4">{{ __('imprint.titleImprint') }}</h1>

        <p class="mb-2">
            <b>Rock Arbeitsgemeinschaft e.V.</b>
        </p>
        <p class="mb-2">
            Ölmühlweg 22a<br>
            61462 Königstein im Taunus<br>
            
        </p>
        <p class="mb-4">
            <a class="underline" href="mailto:info@rockag.net">info@rockag.net</a><br>
        </p>
        <p class="mb-2">
            <b>Vertretungsberechtigt,<br> sowie verantwortlich für den redaktionellen Inhalt:</b>
        </p>
        <p>Der Hauptvorstand, bestehend aus</p>
        <ul class="list-disc pl-8 mb-4">
            <li>Marco Russo <i>(1.Vorsitzender)</i></li>
            <li>Dominik Glienicke <i>(2. Vorsitzender)</i></li>
            <li>André Müller <i>(Kassenwart)</i></li>
            <li>Isabelle Hodson <i>(Schriftführerin)</i></li>
        </ul>
        <p class="">
            <b>Registergericht: </b>Königstein im Taunus<br>
            <b>Registernummer: </b>VR 1181
        </p>

        {{-- Privacy --}}
        <h2 class="section-header mt-6 mb-4">{{ __('imprint.titlePrivacy') }}</h1>

        <p class="mb-2">
            <b>1. Einleitung</b>
        </p>
        <p class="mb-2">
            Als Anbieter dieser Seite sind wir per Gesetz dazu verpflichtet, Sie über Zweck, Umfang, Art der Erhebung und Verwendung Ihrer personenbezogenen Daten zu informieren. Mit dieser Erklärung möchten wir erreichen, dass Sie ein gutes Gefühl bei der Nutzung unserer Website haben. Bei Fragen dürfen Sie sich jederzeit gerne bei uns melden.
        </p>

        <p class="mb-2">
            <b>2. Name und Kontaktdaten der Verantwortlichen</b>
        </p>
        <p class="mb-2">
            Verantwortlich für die Verarbeitung personenbezogener Daten sind die im Impressum genannten Mitglieder des Hauptvorstandes. Sie können die verantwortlichen Personen unter <a class="underline" href="mailto:info@rockag.net">info@rockag.net</a> erreichen.
        </p>

        <p class="mb-2">
            <b>3. Verarbeitung von personenbezogenen Daten, Zweck der Verarbeitung und Speicherdauer</b><br>
        </p>
        <p class="mb-2">
            <i>a) Besuch der Website</i><br>
            Beim Besuch der Website werden keine personenbezogenen Daten erhoben.
        </p>
        <p class="mb-2">
            <i>b) Benutzung des Anmelde-Formulars</i><br>
            Bei der Nutzung des Anmeldeformulars für Schichten werden folgende personenbezogene Daten erhoben:
        </p>
        <ul class="list-disc pl-8 mb-2">
            <li>Name</li>
            <li>Telefonnummer</li>
            <li>E-Mail-Adresse</li>
        </ul>
        <p class="mb-2">
            Die gespeicherten Daten werden verwendet, um dem Verein die Planung der jeweiligen Veranstaltung zu ermöglichen und im Zuge der Planung und Durchführung der Veranstaltung ggf. Kontakt mit Ihnen aufzunehmen. Nach der jeweiligen Veranstaltung werden Ihre Kontaktdaten ggf. genutzt, um Sie über weitere, direkt damit in Verbindung stehende Veranstaltungen (z.B. Helferfest) zu informieren.
        </p>
        <p class="mb-2">
            Die Rechtsgrundlage für diese Verarbeitung ist Ihre Zustimmung laut Art. 6 Abs. 1 S. 1 lit. a) DSGVO.
        </p>
        <p class="mb-2">
            Die erhobenen Daten werden spätestens nach Abschluss der jeweiligen Veranstaltung und ggf. direkt damit verbundener Folgeveranstaltungen (z.B. Helferfest) gelöscht. Bei der Absage der Teilnahme an einer Schicht werden die zugehörigen Daten sofort nach dem Abschluss der Absage gelöscht.
        </p>
        <p class="mb-2">
            Die Bereitstellung dieser Daten ist nicht gesetzlich vorgeschrieben, allerdings ist ohne die Datenverarbeitung eine Bearbeitung von Anmeldungen nicht möglich.
        </p>

        <p class="mb-2">
            <b>4. Recht auf Auskunft über die Daten, Berichtigung, Löschung oder Einschränkung der Verarbeitung, Widerspruchsrecht gegen die Verarbeitung, Recht auf Datenübertragbarkeit</b><br>
        </p>
        <p class="mb-2">
            Jede Person hat das Recht auf Auskunft über die zu seiner/ihrer Person verarbeiteten Daten, auf Berichtigung dieser, auf Löschen dieser und ein Recht auf Einschränkung der Verarbeitung. Zudem steht der Person ein Widerspruchsrecht gegen die Verarbeitung der Daten und gegen die Datenübertragbarkeit zu.
        </p>

        <p class="mb-2">
            <b>5. Bestehen eines Widerrufsrechts</b><br>
        </p>
        <p class="mb-2">
            Ist die Verarbeitung aufgrund einer Einwilligung erfolgt, dann steht jeder Person ein Widerrufsrecht dieser Einwilligung zu. Durch die Ausübung des Widerrufs entfällt nicht die Rechtmäßigkeit der Verarbeitung vor dem Widerruf.
        </p>

        <p class="mb-2">
            <b>5. Bestehen eines Beschwerderechts bei einer Aufsichtsbehörde</b><br>
        </p>
        <p class="mb-2">
            Gem. Art. 77 DSGVO besteht ein Beschwerderecht bei einer Aufsichtsbehörde. In Deutschland ist dies der Bundesbeauftragte für den Datenschutz und Informationsfreiheit.
        </p>
        
    </div>
@endsection