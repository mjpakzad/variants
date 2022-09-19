<?php
namespace App;

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
        $rows = $variation->getData();
        $result = '<table>';
        $result .= '<thead>';
        $result .= '<tr>';
        $result .= '<th>title</th>';
        $result .= '<th>seller_id</th>';
        $result .= '<th>price</th>';
        $result .= '</tr>';
        $result .= '</thead>';
        $result .= '<tbody>';
        foreach ($rows as $row) {
            $result .= '<tr>';
            $result .= '<td>' . $row['title'] . '</td>';
            $result .= '<td>' . $row['seller_id'] . '</td>';
            $result .= '<td>' . $row['price'] . '</td>';
            $result .= '</tr>';
        }
        $result .= '</tbody>';
        $result .= '</table>';
        return $result;
    }
}