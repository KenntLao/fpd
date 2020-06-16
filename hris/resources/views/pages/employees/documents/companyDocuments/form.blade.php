@csrf
<div class="row">
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label class="mr-2" for="name">Name: </label>
            <span class="badge badge-danger">Required</span>
            <div class="input">
                <p class="placeholder">Enter name</p>
                <input class="form-control required" type="text" name="name" value="{{old('name') ?? $document->name}}" required>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label class="mr-2" for="name">Details: </label>
            <div class="input">
                <p class="placeholder">Enter details</p>
                <textarea class="form-control" name="details">{{ old('details') ?? $document->details }}</textarea>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label class="mr-2">Status: </label>
            <span class="badge badge-danger">Required</span>
            <select class="required select2" name="status" required>
                <option disabled default selected>--select one--</option>
                <option value="Active" {{ $document->status == 'Active'  ? 'selected' : '' }} >Active</option>
                <option value="Inactive" {{ $document->status == 'Inactive'  ? 'selected' : '' }} >Inactive</option>
                <option value="Draft" {{ $document->status == 'Draft'  ? 'selected' : '' }} >Draft</option>
            </select>
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label class="mr-2" for="name">Attachment: </label>
            <span class="badge badge-danger">Required</span>
            <input class="form-control" type="file" name="attachment">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label class="mr-2" for="department_id">Share Departments: </label>
            <span class="badge badge-danger">Required</span>
            <select class="required select2" name="department_id[]" multiple="multiple">
                @if(count($departments) > 0)
                <option disabled default>--select one --</option>
                @foreach($departments as $department)
                <option value="{{$department->id}}" {{ in_array($department->id, $department_id) ? 'selected' : '' }}>{{$department->department_name}}</option>
                @endforeach
                @else
                <option disabled default>--select one --</option>
                @endif
            </select>
            <div class="info">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tip-1"><i class="fas fa-fw fa-info"></i></button>
                <!-- Modal -->
                <div class="modal fade" id="tip-1" tabindex="-1" role="dialog" aria-labelledby="tip-1" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Tip</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>This document will be visible to employees from selected department. If no department is selected only Admin users can see this.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label class="mr-2" for="employee_id">Share Employees: </label>
            <select class="required select2" name="employee_id[]" multiple="multiple">
                @if(count($employees) > 0)
                @foreach($employees as $employee)
                <option value="{{$employee->id}}" {{ in_array($employee->id, $employee_id) ? 'selected' : '' }}>{{$employee->firstname}} {{$employee->lastname}}</option>
                @endforeach
                @else
                <option disabled default>--select one--</option>
                @endif
            </select>
            <div class="info">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tip-2"><i class="fas fa-fw fa-info"></i></button>
                <!-- Modal -->
                <div class="modal fade" id="tip-2" tabindex="-1" role="dialog" aria-labelledby="tip-2" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Tip</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Instead of sharing with all the employees in a department, you can share it only with specific employees.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>