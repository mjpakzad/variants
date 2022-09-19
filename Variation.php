<?php
namespace App;

class Variation
{
    private $data = [];

    /**
     * Summarize data and sort it.
     *
     * @param       $data
     * @param array $orders
     */
    public function summarize($data, array $orders = [])
    {
        $data = $this->group($data);
        $this->data = $this->dynamicMultiSort($data, $orders);
    }

    /**
     * Sort rows based on title key asc and seller_id key desc.
     *
     * @param array $rows
     * @param array $orders
     *
     * @return array
     */
    private function sort(array $rows, array $orders = []):array
    {
        if(count($orders) !== 2) {
            $orders = [['key' => 'title', 'dir' => 'asc'], ['key' => 'seller_id', 'dir' => 'desc']];
        }
        array_multisort(
            array_column($rows, $orders[0]['key']), strtolower($orders[0]['dir']) == 'asc' ? SORT_ASC : SORT_DESC,
            array_column($rows, $orders[1]['key']), strtolower($orders[1]['dir']) == 'asc' ? SORT_ASC : SORT_DESC,
            $rows
        );
        return $rows;
    }

    /**
     * Sort data based on array_multisort.
     *
     * @param array $data
     * @param array $orders
     *
     * @return array|mixed
     *
     * @example dynamicMultiSort($data, ['title' => 'asc', 'seller_id' => 'desc'])
     */
    private function dynamicMultiSort(array $data, array $orders = [])
    {
        foreach ($orders as $order => $direction) {
            $params[] = array_column($data, $order);
            $params[] = strtolower($direction) == 'asc' ? SORT_ASC : SORT_DESC;
        }
        if(!isset($params)) {
            return $this->sort($data);
        }
        $params[] = &$data;
        call_user_func_array('array_multisort', $params);
        return $data;
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