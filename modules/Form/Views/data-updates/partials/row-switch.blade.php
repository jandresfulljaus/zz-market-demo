<tr>
    <td>{{ $label }}</td>
    <td>
        <div class="form-check form-check-switchery form-check-switchery-double">
            <label class="form-check-label">
                No
                <input
                    type="checkbox"
                    name="{{ $name }}"
                    class="form-check-input-switchery"
                    {{ old($name) === 'on' ? 'checked' : '' }}
                    data-fouc
                >
                Si
            </label>
        </div>
    </td>
</tr>
