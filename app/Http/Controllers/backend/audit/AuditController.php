<?php

namespace App\Http\Controllers\backend\audit;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuditController extends Controller
{
    public function index()
    {
        $data['title'] =  'Audits'.' || '. get_system_name();
        $data['css'] = array(
            'toastr/toastr.min.css'
        );
        $data['plugincss'] = array(
            'plugins/custom/datatables/table/datatables.bundle.css',
        );
        $data['pluginjs'] = array(
            'toastr/toastr.min.js',
        );
        $data['widgetjs'] = array(
            'plugins/custom/datatables/table/datatables.bundle.js',
        );
        $data['js'] = array(
            'comman_function.js',
            'jquery.form.min.js',
            'audit.js',
        );
        $data['funinit'] = array(
            'Audit.init()'
        );
        $data['header'] = array(
            'title' => 'Audit List',
            'breadcrumb' => array(
                'Dashboard' => route('dashboard'),
                'Audit List' => 'Audit List',
            )
        );
        return view('backend.pages.audit/list', $data);
    }

    public function ajaxcall(Request $request){

        $action = $request->input('action');

        switch ($action) {
            case 'getdatatable':

                    $requestData = $_REQUEST;
                    // ccd($requestData['order'][0]['column']);
                    $columns = array(
                        0 => 'audits.id',
                        1 => 'user.name',
                        2 => 'audits.auditable_type',
                        3 => 'audits.event',
                        4 => 'audits.created_at',
                        5 => 'audits.url',
                        6 => 'audits.url',
                        7 => 'audits.url',
                        8 => 'audits.ip_address',
                        9 => 'audits.user_agent',
                    );
                    $query = \OwenIt\Auditing\Models\Audit::with('user');

                    if (!empty($requestData['search']['value'])) {
                        $searchVal = $requestData['search']['value'];
                        $query->where(function ($query) use ($columns, $searchVal, $requestData) {
                            $flag = 0;
                            foreach ($columns as $key => $value) {
                                $searchVal = $requestData['search']['value'];
                                if ($requestData['columns'][$key]['searchable'] == 'true') {
                                    if ($flag == 0) {
                                        if ($value == 'user.name') {
                                            $query->whereHas('user', function ($q) use ($searchVal) {
                                                $q->where('name', 'like', '%' . $searchVal . '%');
                                            });
                                        }
                                        else {
                                            $query->where($value, 'like', '%' . $searchVal . '%');
                                        }
                                        $flag++;
                                    } else {
                                        if ($value == 'user.name') {
                                            $query->orWhereHas('user', function ($q) use ($searchVal) {
                                                $q->where('name', 'like', '%' . $searchVal . '%');
                                            });
                                        }
                                         else {
                                            $query->orWhere($value, 'like', '%' . $searchVal . '%');
                                        }
                                    }
                                }
                            }
                        });
                    }
                    $columnIndex = $requestData['order'][0]['column'];
                    $columnName = $columns[$columnIndex]; // Column name
                    $columnSortOrder = $requestData['order'][0]['dir']; // asc or desc
                    // ccd($columnSortOrder);

                    if ($columnName == 'user.name') {
                        $query->with(['user' => function($q) use ($columnSortOrder) {
                            $q->orderBy('name', $columnSortOrder);
                        }]);
                    }
                    else {
                        $query->orderBy($columnName, $columnSortOrder);
                    }

                    $totalData = $query->count();
                    $totalFiltered = $query->count();

                    $resultArr = $query->skip($requestData['start'])
                                ->take($requestData['length'])
                                // ->select('audits.new_values')
                                ->get();

                    $data = array();
                    $i = 0;
                    //  dd($resultArr);

                    foreach ($resultArr as $row) {

                        $new_values = '';
                        foreach ($row['new_values'] as $key => $value) {
                            $new_values .= $key . ':' . $value . ', ';
                        }
                        $new_values = rtrim($new_values, ', ');

                        $old_values = '';
                        foreach ($row['old_values'] as $key => $value) {
                            $old_values .= $key . ': ' . $value . ', ';
                        }
                        $old_values = rtrim($old_values, ', ');

                        $i++;
                        $nestedData = array();
                        $nestedData[] = $i;
                        // $nestedData[] = $row['id'];
                        $nestedData[] = $row['user']->name;
                        $nestedData[] = $row['auditable_type']." (id: $row->auditable_id)";
                        $nestedData[] = $row['event'];
                        $nestedData[] = date_time_formate($row['created_at']);
                        $nestedData[] = $old_values =='' ? 'N/A': $old_values ;
                        $nestedData[] = $new_values =='' ? 'N/A': $new_values ;
                        $nestedData[] = $row['url'];
                        $nestedData[] = $row['ip_address'];
                        $nestedData[] = $row['user_agent'];

                        $data[] = $nestedData;
                    }
                    $json_data = array(
                        "draw" => intval($requestData['draw']), // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
                        "recordsTotal" => intval($totalData), // total number of records
                        "recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
                        "data" => $data   // total data array
                    );

                echo json_encode($json_data);
                break;
        }
    }
}
