@extends('layouts.admin')

@section('title', "Modules - {$course->title}")

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <div class="text-xs font-bold text-white/40 uppercase tracking-wider mb-1">Curriculum Builder</div>
            <h1 class="text-2xl font-bold">{{ $course->title }} — Modules</h1>
        </div>
        <button onclick="document.getElementById('create-modal').classList.remove('hidden')" class="btn-primary">
            + Add Module
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif

    <div class="card overflow-hidden">
        @if($course->modules->count())
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-white/5 text-xs font-bold text-white/40 uppercase tracking-wider">
                            <th class="text-left px-5 py-3">#</th>
                            <th class="text-left px-5 py-3">Title</th>
                            <th class="text-left px-5 py-3">Lessons</th>
                            <th class="text-right px-5 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($course->modules as $i => $module)
                            <tr class="table-row">
                                <td class="px-5 py-3 text-white/40">{{ $module->sort_order ?? $i + 1 }}</td>
                                <td class="px-5 py-3 font-medium">{{ $module->title }}</td>
                                <td class="px-5 py-3">
                                    <a href="{{ route('admin.curriculum.lessons', $module) }}" class="text-mint hover:underline">
                                        {{ $module->lessons->count() }} lessons
                                    </a>
                                </td>
                                <td class="px-5 py-3 text-right">
                                    <button onclick="editModule({{ $module->id }}, '{{ $module->title }}', '{{ $module->description }}', {{ $module->sort_order ?? $i + 1 }})" class="btn-secondary btn-sm text-xs">Edit</button>
                                    <form method="POST" action="{{ route('admin.curriculum.modules.destroy', $module) }}" class="inline" onsubmit="return confirm('Delete this module and all its lessons?')">
                                        @csrf @method('DELETE')
                                        <button class="btn-danger btn-sm text-xs">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-8 text-center text-white/40">
                <p>No modules yet. Click "Add Module" to start building.</p>
            </div>
        @endif
    </div>

    {{-- Create Modal --}}
    <div id="create-modal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black/60 backdrop-blur-sm">
        <div class="bg-gray-900 rounded-2xl p-6 w-full max-w-lg mx-4 shadow-2xl border border-white/10">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-lg font-bold">Create Module</h3>
                <button onclick="document.getElementById('create-modal').classList.add('hidden')" class="text-white/40 hover:text-white text-xl leading-none">&times;</button>
            </div>
            <form method="POST" action="{{ route('admin.curriculum.modules.store', $course) }}" class="space-y-4">
                @csrf
                <div>
                    <label class="label">Title</label>
                    <input type="text" name="title" class="input w-full" required maxlength="255">
                </div>
                <div>
                    <label class="label">Description</label>
                    <textarea name="description" class="input w-full" rows="3" maxlength="2000"></textarea>
                </div>
                <div>
                    <label class="label">Sort Order</label>
                    <input type="number" name="sort_order" class="input w-24" min="0" value="{{ $course->modules->count() }}">
                </div>
                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" onclick="document.getElementById('create-modal').classList.add('hidden')" class="btn-secondary btn-sm">Cancel</button>
                    <button type="submit" class="btn-primary btn-sm">Create</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Edit Modal --}}
    <div id="edit-modal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black/60 backdrop-blur-sm">
        <div class="bg-gray-900 rounded-2xl p-6 w-full max-w-lg mx-4 shadow-2xl border border-white/10">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-lg font-bold">Edit Module</h3>
                <button onclick="document.getElementById('edit-modal').classList.add('hidden')" class="text-white/40 hover:text-white text-xl leading-none">&times;</button>
            </div>
            <form method="POST" action="" id="edit-module-form" class="space-y-4">
                @csrf @method('PUT')
                <div>
                    <label class="label">Title</label>
                    <input type="text" name="title" id="edit-title" class="input w-full" required maxlength="255">
                </div>
                <div>
                    <label class="label">Description</label>
                    <textarea name="description" id="edit-description" class="input w-full" rows="3" maxlength="2000"></textarea>
                </div>
                <div>
                    <label class="label">Sort Order</label>
                    <input type="number" name="sort_order" id="edit-sort" class="input w-24" min="0">
                </div>
                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" onclick="document.getElementById('edit-modal').classList.add('hidden')" class="btn-secondary btn-sm">Cancel</button>
                    <button type="submit" class="btn-primary btn-sm">Update</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function editModule(id, title, description, sortOrder) {
            document.getElementById('edit-module-form').action = '{{ url("admin/curriculum/modules") }}/' + id;
            document.getElementById('edit-title').value = title;
            document.getElementById('edit-description').value = description;
            document.getElementById('edit-sort').value = sortOrder;
            document.getElementById('edit-modal').classList.remove('hidden');
        }
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.getElementById('create-modal').classList.add('hidden');
                document.getElementById('edit-modal').classList.add('hidden');
            }
        });
    </script>
@endsection
