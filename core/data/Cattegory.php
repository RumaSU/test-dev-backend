<?php

namespace Core\Data;

class Cattegory {
    
    public static function aggregator(array $data) {
        $result = [
            'total' => 0,
            'data' => []
        ];
        
        // "data": [
        // {
        //     "category": "Buah",
        //     "code": "B001",
        //     "name": "Apel",
        //     "total": 10
        // },
        
        foreach($data as $item) {
            
            $catt = $item['category'];
            $code = $item['code'];
            $result['total'] += $item['total'];
            
            if (!isset($result['data'][$catt])) {
                $result['data'][$catt] = [
                    'category' => $catt,
                    'total' => 0,
                    'data' => []
                ];
            }
            
            $result['data'][$catt]['total'] += $item['total'];
            
            if (!isset($result['data'][$catt]['data'][$code])) {
                $result['data'][$catt]['data'][$code] = [
                    'total' => 0,
                    'data' => []
                ];
            }
            ksort($result['data'][$catt]['data']);
            
            
            $result['data'][$catt]['data'][$code]['total'] += $item['total'];
            
            $result['data'][$catt]['data'][$code]['data'][] = [
                'name' => $item['name'],
                'total' => $item['total']
            ];
            
            sort($result['data'][$catt]['data'][$code]['data']);
        }
        
        
        
        $result['data'] = array_values($result['data']);
        return $result;
    }
    
}