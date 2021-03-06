<?php

namespace App\Http\Controllers;

use App\Connection;
use Illuminate\Http\Request;
use App\ConnectionTemplateRepository;

class ConnectionController extends Controller
{
    protected $templateRepository;

    public function __construct(ConnectionTemplateRepository $templateRepository)
    {
        $this->templateRepository = $templateRepository;
        $this->authorizeResource(Connection::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('index', Connection::class);

        $data = [
            'title' => 'Connections Available',
            'connections' => Connection::all(),
        ];

        return view('connections.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'title' => 'Create Connection',
            'templates' => $this->templateRepository->getTemplatesArray(),
        ];

        return view('connections.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $connection = Connection::create($request->all());

        return redirect(route('connections.show', $connection->name));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Connection  $connection
     * @return \Illuminate\Http\Response
     */
    public function show(Connection $connection)
    {
        $data = [
            'title' => "Connection {$connection->name}",
            'connection' => $connection,
        ];

        return view('connections.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Connection  $connection
     * @return \Illuminate\Http\Response
     */
    public function edit(Connection $connection)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Connection  $connection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Connection $connection)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Connection  $connection
     * @return \Illuminate\Http\Response
     */
    public function destroy(Connection $connection)
    {
        //
    }
}
