<div class="form-row">
    <div class="form-group">
        <label class="form-label">
            Full Name <span class="required">*</span>
        </label>
        <input type="text" 
               name="name" 
               class="form-control" 
               value="{{ old('name', $employee->name ?? '') }}" 
               placeholder="Enter employee full name"
               required>
    </div>

    <div class="form-group">
        <label class="form-label">
            Email Address <span class="required">*</span>
        </label>
        <input type="email" 
               name="email" 
               class="form-control" 
               value="{{ old('email', $employee->email ?? '') }}" 
               placeholder="employee@company.com"
               required>
    </div>
</div>

<div class="form-row">
    <div class="form-group">
        <label class="form-label">
            Role <span class="required">*</span>
        </label>
        <select name="role_id" class="form-control" required>
            <option value="">Select a role</option>
            @foreach($roles as $role)
                <option value="{{ $role->id }}" 
                    {{ old('role_id', $employee->role_id ?? '') == $role->id ? 'selected' : '' }}>
                    {{ $role->title }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label class="form-label">
            Department <span class="required">*</span>
        </label>
        <select name="department_id" class="form-control" required>
            <option value="">Select a department</option>
            @foreach($departments as $department)
                <option value="{{ $department->id }}" 
                    {{ old('department_id', $employee->department_id ?? '') == $department->id ? 'selected' : '' }}>
                    {{ $department->name }}
                </option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-group">
    <label class="form-label">
        Password 
        @if(!isset($employee))
            <span class="required">*</span>
        @else
            <small style="color: #6b7280; font-weight: 400;">(Leave blank to keep current password)</small>
        @endif
    </label>
    <input type="password" 
           name="password" 
           class="form-control" 
           placeholder="{{ isset($employee) ? '••••••••' : 'Enter secure password' }}"
           {{ !isset($employee) ? 'required' : '' }}>
</div>