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
                $rows[] = [
                    'title'     => $datum['title'],
                    'seller_id' => $datum['seller_id'],
                    'price'     => $datum['price'],
                    'rate_sum'  => $datum['rate'],
                    'count'     => 1,
                ];
                continue;
            }
            if(!isset($rows[$datum['title']])) {
                $rows[$datum['title']] = [
                    'title'     => $datum['title'],
                    'seller_id' => $datum['seller_id'],
                    'price'     => $datum['price'],
                    'rate_sum'  => $datum['rate'],
                    'count'     => 1,
                ];
                continue;
            }
            $rows[$datum['title']] = [
                'title'     => $datum['title'],
                'seller_id' => $rows[$datum['title']]['seller_id'] . ',' . $datum['seller_id'],
                'price'     => $rows[$datum['title']]['price'] + $datum['price'],
                'rate_sum'  => $rows[$datum['title']]['rate_sum'] + $datum['rate'],
                'count'     => ++$rows[$datum['title']]['count'],
            ];
        }
        return $this->avg($rows);
    }

    /**
     * Return average of rate based on rate_sum and count.
     *
     * @param array $rows
     *
     * @return array
     */
    private function avg(array $rows): array
    {
        return array_map(function ($row) {
            $row['rate'] = $row['rate_sum'] / $row['count'];
            unset($row['rate_sum'], $row['count']);
            return $row;
        }, $rows);
}
}