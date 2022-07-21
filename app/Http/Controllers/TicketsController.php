<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class TicketsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function __construct()
    // {
    //     // $this->middleware('admin', ['except' => ['store']]);
    //     $this->middleware('admin')->except('store');
    // }
    public function index()
    {
        $ticket = Ticket::all(); //Fungsi untuk mengambil seluruh data pada tabel books

        return view('admin.ticket.index', [
            'tickets' => $ticket
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ticket.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'alamat' => 'required'
        ]);
        Ticket::create([
            'name' => $request->name,
            'alamat' => $request->alamat
        ]);
        return view('ticket.index');
        // try {
        //     //code...
        //     Ticket::create($request->all());
        //     return back()->with('success', 'Berhasil Beli Tiket');
        // } catch (\Throwable $th) {
        //     return back()->with('error', $th);
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ticket = Ticket::where('id', $id)->first();
        return view('admin.ticket.edit', [
            'ticket' => $ticket
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required', //nama form "name" harus diisi (required)
            'alamat' => 'required', //nama form "alamat" harus diisi (required)
        ]); //Memvalidasi inputan yang kita kirim apakah sudah benar
        Ticket::where('id', $id)->update([
            'name' => $request->name,
            'alamat' => $request->alamat
        ]); //Fungsi untuk mengupdate data inputan

        return redirect()->to(route('ticket.index'))->with('success', 'Ticket Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ticket = Ticket::where('id', $id)->first();
        if (empty($ticket)) {
            return back()->with('message', 'Error');
        }
        $ticket->delete();
        return redirect()->to(route('ticket.index'))->with('success', 'Berhasil Delete');
    }
    public function checkIn($id)
    {
        $ticket = Ticket::where('id', $id)->first();
        $ticket->update([
            'check_in' => true,
        ]);
        return redirect()->to(route('ticket.index'))->with('success', 'Berhasil Checkin');
    }
    public function searchPage()
    {
        return view('admin.ticket.search');
    }
    public function searchLogic(Request $request)
    {
        $request = $request->all();
        // chcek null value
        if (empty($request['query'])) {
            return view('admin.ticket.search', [
                'message' => 'query is Required'
            ]);
        }

        // check query format

        if (Str::contains($request['query'], 'Ticket-')) {
            $search = explode('-', $request['query'])[1];
            $ticket = Ticket::where('id', $search)->first();
            // check ticket status ( checkin atau belum)
            if ($ticket->check_in) {
                return view('admin.ticket.search', [
                    'error' => 'Ticket is already check in'
                ]);
            }
            return view('admin.ticket.search', [
                'data' => $ticket
            ]);
        } else {
            return view('admin.ticket.search', [
                'error' => 'Ticket code format is invalid'
            ]);
        }
    }
}
