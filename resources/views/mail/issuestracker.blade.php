<table>
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
</table>