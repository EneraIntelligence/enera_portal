<table>
    <tr>
        <td><b>Host:</b></td>
        <td>{{ gethostname() }}</td>
    </tr>
    <tr>
        <td><b>Path:</b></td>
        <td>{{ $request->path() }}</td>
    </tr>
    <tr>
        <td><b>Url:</b></td>
        <td>{{ $request->url() }}</td>
    </tr>
    <tr>
        <td><b>Code:</b></td>
        <td>{{ $ex->getCode() }}</td>
    </tr>
    <tr>
        <td><b>File:</b></td>
        <td>{{ $ex->getFile() }}</td>
    </tr>
    <tr>
        <td><b>Line:</b></td>
        <td>{{ $ex->getLine() }}</td>
    </tr>
    <tr>
        <td><b>Message:</b></td>
        <td>{{ $ex->getMessage() }}</td>
    </tr>
    <tr>
        <td><b>Trace:</b></td>
        <td>{{ $ex->getTraceAsString() }}</td>
    </tr>
    <tr>
        <td><b>Session vars:</b></td>
        <td>
            {{ json_encode($session_vars) }}
        </td>
    </tr>
</table>