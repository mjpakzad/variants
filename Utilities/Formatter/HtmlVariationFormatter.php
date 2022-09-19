<?php
namespace App\Utilities\Formatter;

use App\Variation;

class HtmlVariationFormatter implements FormattableVariation
{
    /**
     * Format and return data as a table
     * @param \App\Variation $variation
     *
     * @return string
     */
    public function format(Variation $variation)
    {
        $rows   = $variation->getData();
        $html   = $this->html();
        $table  = $this->table($rows);
        $html   = str_replace('@title', 'Html format of variants', $html);
        return str_replace('@content', $table, $html);
    }

    /**
     * Create table from
     *
     * @param array $rows
     *
     * @return string
     */
    private function table(array $rows):string
    {
        $result = '<table>' . PHP_EOL;
        $result .= '<thead>' . PHP_EOL;
        $result .= '<tr>' . PHP_EOL;
        $result .= '<th>title</th>' . PHP_EOL;
        $result .= '<th>seller_id</th>' . PHP_EOL;
        $result .= '<th>price</th>' . PHP_EOL;
        $result .= '<th>rate</th>' . PHP_EOL;
        $result .= '</tr>' . PHP_EOL;
        $result .= '</thead>' . PHP_EOL;
        $result .= '<tbody>' . PHP_EOL;
        foreach ($rows as $row) {
            $result .= '<tr>' . PHP_EOL;
            $result .= '<td>' . $row['title'] . '</td>' . PHP_EOL;
            $result .= '<td>' . $row['seller_id'] . '</td>' . PHP_EOL;
            $result .= '<td>' . $row['price'] . '</td>' . PHP_EOL;
            $result .= '<td>' . $row['rate'] . '</td>' . PHP_EOL;
            $result .= '</tr>' . PHP_EOL;
        }
        $result .= '</tbody>' . PHP_EOL;
        $result .= '</table>' . PHP_EOL;
        return $result;
    }

    /**
     * Create html structure.
     *
     * @return string
     */
    private function html(): string
    {
        return <<<EOL
        <!DOCTYPE html>
        <html>
        <head>
            <title>@title</title>
            <style>
                table, th, td {
                    border: 1px solid black;
                    border-collapse: collapse;
                }
                th {
                    background-color: #96D4D4;
                }
                th, td {
                    padding: 15px;
                }
            </style>
        </head>
        <body>@content</body>
        </html>
        EOL;
    }
}