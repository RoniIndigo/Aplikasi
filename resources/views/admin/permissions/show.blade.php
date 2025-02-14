@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        Show Permission
    </div>
    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.permissions.index') }}">
                    Back
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            ID
                        </th>
                        <td>
                            {{ $permission->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Permission
                        </th>
                        <td>
                            {{ $permission->title }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
