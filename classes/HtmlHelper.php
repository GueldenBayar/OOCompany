<?php
class HtmlHelper
{
//    definieren eine Funktion, die jeder benutzen kann (public static), $actionEdit und $actionDelete sind optional (default: ')
//    Sie nimmt zwei Dinge an: Die Liste der Überschriften ($kopfZeilen) und die echten Inhalte ($inhalte)
    public static function baueTabelle(array $kopfZeilen, array $datenZeilen, string $actionEdit = '', string $actionDelete = ''): string
    {
        $html = '<table style="border= 1px solid #ddd; border-collapse: collapse; width: 100%;">';

        //Tabellen Kopf
        $html .= '<thead>'; //Start des Kopf-Bereichs
        $html .= '<tr>'; //Start einer Tabellen-Zeile (Table Row)

        foreach ($kopfZeilen as $titel) {
            //nimm die Ueberschrift und pack sie in eine Kopf-Zelle
            $html .= '<th>' . htmlspecialchars($titel) . '</th>';
        }

        //nur Buttons-Spalte anzeigen, wenn Aktionen vorhanden sind
        if ($actionEdit !== '' || $actionDelete !== '') {
            $html .= '<th>Aktionen</th>';
        }

        $html .= '</tr></thead>';

        //Tabellen-Körper für die Daten
        $html .= '<tbody>';

        //2-dimensionales Array: für jeden Datensatz (Zeile) in den Inhalten
        foreach ($datenZeilen as $zeile) {
            $html .= '<tr>'; //Neue Zeile im Regal aufmachen

            //Da der Datensatz selbst auch Array, nochmal durchlaufen
            foreach ($zeile as $einzelnerWert) {
                //packe den Wert in eine normale Zelle (td)
                $html .= '<td>' . htmlspecialchars((string)$einzelnerWert) . '</td>';
            }

            if ($actionEdit !== '' || $actionDelete !== '') {
                //id annehmen: erste Spalte enthält id (Konvention)
                $id = $zeile[0] ?? '';
                $html .= '<td>';
                if ($actionEdit !== '') {
                    $html .= '<a href="index.php?action=' . urlencode($actionEdit) . '&id=' . urlencode((string)$id) . '"><button>Edit</button></a>';
                }
                if ($actionDelete !== '') {
                    $html .= '<a href="index.php?action=' . urlencode($actionDelete) . '&id=' . urlencode((string)$id) . '" onclick="return confirm(\'Wirklich löschen?\');"><button>Löschen</button></a>';
                }
                $html .= '</td>';
            }

            $html .= '</tr>';

        }

        $html .= '</tbody></table>';

        //Der Roboter ist fertig und gibt uns den HTML Code zurück
        return $html;
    }
}

//Die erste Schleife geht von oben nach unten (Zeile 1, Zeile 2, Zeile 3)
//Die zweite Schleife geht innerhalb der Zeile von links nach rechts (Zgithugitelle 1, Zelle 2, Zelle 3)