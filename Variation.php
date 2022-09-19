<?php
namespace App;

class Variation
{
    private $data = [];

    public function summarize($data)
    {
        $data = $this->group($data);
        $this->data = $this->sort($data);
    }

    /**
     * Sort rows based on title key asc and seller_id key desc.
     *
     * @param array $rows
     *
     * @return array
     */
    private function sort(array $rows):array
    {
        array_multisort(
            array_column($rows, 'title'), SORT_ASC,
            array_column($rows, 'seller_id'), SORT_DESC,
            $rows
        );
        return $rows;
    }

    /**
     * Return rows.
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * Group data based on title except for seller_id with a rate equal to 5.
     *
     * @param array $data
     *
     * @return array
     */
    private function group(array $data): array
    {
        $rows = [];
        foreach ($data as $datum) {
            if($datum['rate'] == 5) {
                $rows[] = $datum;
                continue;
            }
            if(!isset($rows[$datum['title']])) {
                $rows[$datum['title']] = $datum;
                continue;
            }
            $rows[$datum['title']] = [
                'title' => $datum['title'],
                'seller_id' => $rows[$datum['title']]['seller_id'] . ',' . $datum['seller_id'],
                'price' => $rows[$datum['title']]['price'] + $datum['price'],
            ];
        }
        return $rows;
    }
}