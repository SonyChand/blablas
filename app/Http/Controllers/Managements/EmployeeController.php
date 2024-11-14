<?php

namespace App\Http\Controllers\Managements;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\View\View;
use App\Traits\TwilioTrait;
use Illuminate\Support\Str;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Managements\Employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Foundation\Validation\ValidatesRequests;

class EmployeeController extends Controller
{
    use ValidatesRequests, TwilioTrait, LogsActivity;

    function __construct()
    {
        $this->middleware('permission:employee-list|employee-create|employee-edit|employee-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:employee-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:employee-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:employee-delete', ['only' => ['destroy', 'bulkDestroy']]);
    }

    public function index(): View
    {
        $title = 'Data Pegawai';
        $employees = Employee::orderBy('id', 'DESC')->get();

        return view('dashboard.managements.employees.index', compact('employees', 'title'));
    }

    public function create(): View
    {
        $title = 'Tambah Data Pegawai';
        $users = User::all();
        return view('dashboard.managements.employees.create', compact('title', 'users'));
    }

    public function store(Request $request): RedirectResponse
    {

        $validatedData = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'email' => 'required|email|unique:users,email|unique:employees,email',
            'name' => 'required|string',
            'employee_type' => 'required|in:PNS,PPPK',
            'employee_identification_number' => 'required|string|unique:employees',
            'birth_place' => 'required|string',
            'birth_date' => 'required|date',
            'rank_start_date' => 'required|date',
            'rank' => 'nullable|string',
            'position_start_date' => 'required|date',
            'position' => 'nullable|string',
            'education_level' => 'nullable|string',
            'education_institution' => 'nullable|string',
            'major' => 'nullable|string',
            'graduation_date' => 'nullable|date',
            'work_unit' => 'nullable|string',
        ]);

        $validatedData['uuid'] = (string) Str::uuid();

        $employee = Employee::create($validatedData);

        $description = 'Pengguna ' . Auth::user()->name . ' menambahkan data pegawai dengan NIP: ' . $employee->employee_identification_number;
        $this->logActivity('employees', Auth::user(), $employee->id, $description);

        return redirect()->route('employees.index')
            ->with('success', 'Data pegawai berhasil ditambahkan.');
    }

    public function edit(Employee $employee): View
    {
        $title = 'Edit Data Pegawai';
        $users = User::all();
        return view('dashboard.managements.employees.edit', compact('employee', 'title', 'users'));
    }

    public function update(Request $request, Employee $employee): RedirectResponse
    {

        $validatedData = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'name' => 'required|string',
            'employee_type' => 'required|in:PNS,PPPK',
            'employee_identification_number' => 'required|string|unique:employees,employee_identification_number,' . $employee->id,
            'birth_place' => 'required|string',
            'birth_date' => 'required|date',
            'rank_start_date' => 'required|date',
            'rank' => 'nullable|string',
            'position_start_date' => 'required|date',
            'position' => 'nullable|string',
            'education_level' => 'nullable|string',
            'education_institution' => 'nullable|string',
            'major' => 'nullable|string',
            'graduation_date' => 'nullable|date',
            'work_unit' => 'nullable|string',
        ]);


        // Check if email is present in the request and is different from the current email
        if ($request->has('email') && $request->email !== $employee->email) {
            $request->validate([
                'email' => 'nullable|email|unique:users,email,' . $employee->user_id . '|unique:employees,email,' . $employee->id,
            ]);
            $validatedData['email'] = $request->email;
        } else {
            // If email is not present or not changed, retain the current email
            $validatedData['email'] = $employee->email;
        }

        // Handle user account creation or linking


        $originalData = $employee->toArray();
        $changes = [];

        $originalData['birth_date'] = Carbon::parse($originalData['birth_date'])->setTimezone('Asia/Jakarta')->startOfDay();
        $validatedData['birth_date'] = Carbon::parse($validatedData['birth_date'])->startOfDay();
        $originalData['rank_start_date'] = Carbon::parse($originalData['rank_start_date'])->setTimezone('Asia/Jakarta')->startOfDay();
        $validatedData['rank_start_date'] = Carbon::parse($validatedData['rank_start_date'])->startOfDay();
        $originalData['position_start_date'] = Carbon::parse($originalData['position_start_date'])->setTimezone('Asia/Jakarta')->startOfDay();
        $validatedData['position_start_date'] = Carbon::parse($validatedData['position_start_date'])->startOfDay();
        $originalData['graduation_date'] = Carbon::parse($originalData['graduation_date'])->setTimezone('Asia/Jakarta')->startOfDay();
        $validatedData['graduation_date'] = Carbon::parse($validatedData['graduation_date'])->startOfDay();

        foreach ($validatedData as $key => $value) {
            if ($originalData[$key] != $value) {
                $changes[] = $key;
            }
        }

        if (empty($changes)) {
            return redirect()->route('employees.edit', $employee->id)
                ->with('info', 'Tidak ada perubahan yang dilakukan.');
        }

        $employee->update($validatedData);

        $description = 'Pengguna ' . Auth::user()->name . ' mengubah kolom: ' . implode(', ', $changes) . ' pada data pegawai dengan NIP: ' . $employee->employee_identification_number;
        $this->logActivity('employees', Auth::user(), $employee->id, $description);

        return redirect()->route('employees.index')
            ->with('success', 'Data pegawai berhasil diperbarui.');
    }

    public function destroy($id): RedirectResponse
    {
        $employee = Employee::find($id);
        if ($employee) {
            $description = 'Pengguna ' . Auth::user()->name . ' menghapus data pegawai dengan NIP: ' . $employee->employee_identification_number;
            $this->logActivity('employees', Auth::user(), $employee->id, $description);

            $message = 'Pengguna ' . Auth::user()->name . ' telah menghapus data pegawai dengan NIP: ' . $employee->employee_identification_number;
            $sendMessageResult = $this->sendWhatsAppMessageToAdmin($message);

            if ($sendMessageResult !== true) {
                return back()->with(['error' => $sendMessageResult]);
            }

            $employee->delete();

            return redirect()->route('employees.index')
                ->with('success', 'Data pegawai berhasil dihapus.');
        }

        return redirect()->route('employees.index')
            ->with('error', 'Data pegawai tidak ditemukan.');
    }

    public function bulkDestroy(Request $request): RedirectResponse
    {
        $employeeIds = explode(',', $request->input('employeeIds', ''));
        if (!empty($employeeIds)) {
            $employeeNips = Employee::whereIn('id', $employeeIds)
                ->pluck('employee_identification_number')
                ->toArray();

            $message = 'Pengguna ' . Auth::user()->name . ' telah menghapus data pegawai dengan NIP: ' . implode(', ', $employeeNips);
            $sendMessageResult = $this->sendWhatsAppMessageToAdmin($message);

            if ($sendMessageResult !== true) {
                return back()->with(['error' => $sendMessageResult]);
            }

            foreach ($employeeIds as $employeeId) {
                $employee = Employee::find($employeeId);
                if ($employee) {
                    $description = 'Pengguna ' . Auth::user()->name . ' menghapus data pegawai dengan NIP: ' . $employee->employee_identification_number;
                    $this->logActivity('employees', Auth::user(), $employee->id, $description);
                }
            }

            Employee::whereIn('id', $employeeIds)->delete();

            return redirect()->route('employees.index')
                ->with('success', 'Data pegawai berhasil dihapus.');
        }

        return redirect()->route('employees.index')
            ->with('error', 'Data pegawai tidak ditemukan.');
    }

    public function disconnect($id): RedirectResponse
    {
        $employee = Employee::findOrFail($id);
        $employee->user_id = null;
        $employee->save();

        return redirect()->route('employees.edit', $employee->id)
            ->with('success', 'Koneksi akun berhasil diputuskan.');
    }
}
