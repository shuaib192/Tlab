@extends('school.layouts.school')
@section('title', 'Teacher Provisioning - School Portal')
@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="font-black text-2xl text-ink">Teacher Account Provisioning</h1>
        <p class="text-muted text-sm font-semibold">{{ $school->name }}</p>
    </div>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
    <h2 class="font-black text-lg text-ink mb-2">Add Teachers</h2>
    <p class="text-sm text-muted font-semibold mb-6">Create teacher accounts for your school. Teachers will receive their login credentials via email.</p>
    <form method="POST">
        @csrf
        <div id="teacher-rows">
            <div class="grid grid-cols-2 gap-4 mb-4 teacher-row">
                <div>
                    <label class="block text-xs font-bold uppercase text-muted mb-2">Full Name</label>
                    <input type="text" name="teachers[0][name]" required class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm" placeholder="e.g. Mr. John Doe">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-muted mb-2">Email Address</label>
                    <input type="email" name="teachers[0][email]" required class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm" placeholder="teacher@school.edu">
                </div>
            </div>
        </div>
        <button type="button" onclick="addRow()" class="text-sm font-bold text-primary hover:text-primary/80 mb-6 inline-flex items-center gap-1">+ Add Another Teacher</button>
        <button type="submit" class="w-full bg-primary text-white py-3 rounded-xl font-bold text-sm hover:bg-primary/90 transition-all">Provision Teacher Accounts</button>
    </form>
</div>

<script>
let rowIndex = 1;
function addRow() {
    const container = document.getElementById('teacher-rows');
    const div = document.createElement('div');
    div.className = 'grid grid-cols-2 gap-4 mb-4 teacher-row';
    div.innerHTML = `
        <div><label class="block text-xs font-bold uppercase text-muted mb-2">Full Name</label>
            <input type="text" name="teachers[${rowIndex}][name]" required class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm" placeholder="e.g. Mrs. Jane Smith"></div>
        <div><label class="block text-xs font-bold uppercase text-muted mb-2">Email Address</label>
            <input type="email" name="teachers[${rowIndex}][email]" required class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm" placeholder="teacher@school.edu"></div>
    `;
    container.appendChild(div);
    rowIndex++;
}
</script>
@endsection
