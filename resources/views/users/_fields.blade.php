{{ csrf_field() }}

<div class="form-group">
    <label for="name">Nombre:</label>
    <input type="text" class="form-control" name="first_name" id="first_name" placeholder="Pedro" value="{{ old('first_name', $user->first_name) }}">
</div>
<div class="form-group">
    <label for="name">Apellido:</label>
    <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Perez" value="{{ old('last_name', $user->last_name) }}">
</div>

<div class="form-group">
    <label for="email">Correo electrónico:</label>
    <input type="email" class="form-control" name="email" id="email" placeholder="pedro@example.com" value="{{ old('email', $user->email) }}">
</div>

<div class="form-group">
    <label for="password">Contraseña:</label>
    <input type="password" class="form-control" name="password" id="password" placeholder="Mayor a 6 caracteres">
</div>

<div class="form-group">
    <label for="bio">Biografia:</label>
    <textarea name="bio" id="bio" class="form-control">{{ old('bio', $user->profile->bio)}}</textarea>
</div>


<div class="form-group">
    <label for="twitter">Profesión:</label>
    <select name="profession_id" id="profession_id" class="form-control">
        <option value="">Seleccione un Profesión</option>
        @foreach($professions as $profession)
        <option value="{{ $profession->id }}"{{ old('profession_id', $user->profile->profession_id) == $profession->id ? ' selected' : '' }}>
                {{ $profession->title }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="twitter">Twitter:</label>
    <input type="twitter" class="form-control" name="twitter" id="twitter" value="{{ old('twitter', $user->profile->twitter) }}" placeholder="">
</div>

<h6>Habilidades:</h6>
@foreach($skills as $skill)
    <div class="form-check form-check-inline">
            <input 
            name="skills[{{$skill->id}}]"
            type="checkbox" 
            class="form-check-input" 
            id="skill_{{ $skill->id }}"
            value="{{ $skill->id }}" 
            {{-- old("skills.{$skill->id}")?'checked':'' --}}
            {{ $errors->any() ? old("skills.{$skill->id}") : $user->skills->contains($skill) ? 'checked' : '' }}
            >
    
    <label class="form-check-label" for="skill_{{ $skill->id}}">{{ $skill->name }}</label>
    </div>
@endforeach

<h6  class="mt-3">Rol</h6>
@foreach($roles as $role => $name)
    <div class="form-check form-check-inline">
        <input class="form-check-input" 
        type="radio" 
        name="role" 
        id="role_{{ $role }}" 
        value="{{ $role }}"
               {{ old('role', $user->role) == $role ? 'checked' : '' }}>
        <label class="form-check-label" for="role_{{ $role}}">{{ $name }}</label>
    </div>
@endforeach