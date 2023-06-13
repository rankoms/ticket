<?php

namespace App\Imports;

use App\Helpers\ResponseFormatter;
use App\Models\Ticket;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class TicketImport implements ToCollection, WithHeadingRow
{

    /** @var Collection */
    public $collection;


    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $this->collection = $collection->transform(function ($row) {
            $row->merge(['company_id' => Auth::user()->company_id]);
            $this->validationFields($row);


            return [
                'no'                        => $row['no'],
                'event'                     => $row['event'],
                'category'                  => $row['category'],
                'name'                      => $row['name'],
                'email'                     => $row['email'],
                'barcode_no'                => $row['barcode_no'],
                'max_checkin'               => $row['max_checkin'],
                'is_bypass'                 => $row['is_bypass'],
            ];
        });
        $data_ticket = [];
        foreach ($this->collection as $key => $value) :

            array_push(
                $data_ticket,
                [
                    'event' => $value['event'],
                    'category' => $value['category'],
                    'barcode_no' => $value['barcode_no'],
                    'max_checkin' => $value['max_checkin'],
                    'is_bypass' => $value['is_bypass'],
                    'name' => $value['name'],
                    'email' => $value['email']
                ]
            );
        endforeach;
        Ticket::insert($data_ticket);
    }

    public function validationFields($row)
    {
        $event = $row['event'];
        $barcode_no = $row['barcode_no'];

        $customMessages = [
            'unique' => ':input Already Exist '
        ];
        Validator::make($row->toArray(), [
            'barcode_no' => [
                'required', Rule::unique('tickets')->where(function ($query) use ($event, $barcode_no) {
                    $query->where('barcode_no', $barcode_no)
                        ->where('event', $event);
                }),
            ],
        ], $customMessages)->validate();
    }
}
