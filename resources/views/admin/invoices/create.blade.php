@extends('layouts.admin')
@section('title', 'Create Invoice')

@section('content')
<div class="max-w-2xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.invoices.index') }}" class="btn-secondary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back
        </a>
        <div>
            <h1 class="font-display text-3xl font-bold mb-1">Create Invoice</h1>
            <p class="text-cream/50 text-sm">Generate a new invoice for a user.</p>
        </div>
    </div>

    <div class="card p-6">
        <form method="POST" action="{{ route('admin.invoices.store') }}">
            @csrf

            <div class="mb-5">
                <label class="label">User</label>
                <select name="user_id" class="input" required>
                    <option value="">Select a user...</option>
                    @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }} ({{ $user->email }})
                    </option>
                    @endforeach
                </select>
                @error('user_id') <p class="text-terra text-xs font-bold mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4 mb-5">
                <div>
                    <label class="label">Amount (in smallest unit, e.g. cents)</label>
                    <input type="number" name="amount" class="input" placeholder="5000" value="{{ old('amount') }}" required min="1">
                    @error('amount') <p class="text-terra text-xs font-bold mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="label">Currency</label>
                    <select name="currency" class="input" required>
                        <option value="NGN" {{ old('currency') === 'NGN' ? 'selected' : '' }}>NGN</option>
                        <option value="USD" {{ old('currency') === 'USD' ? 'selected' : '' }}>USD</option>
                        <option value="GBP" {{ old('currency') === 'GBP' ? 'selected' : '' }}>GBP</option>
                    </select>
                </div>
            </div>

            <div class="mb-5">
                <label class="label">Due Date</label>
                <input type="date" name="due_date" class="input" value="{{ old('due_date') }}">
                @error('due_date') <p class="text-terra text-xs font-bold mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-5">
                <label class="label">Items (JSON)</label>
                <textarea name="items" class="input" rows="4" placeholder='[{"description":"Course Fee","amount":5000}]'>{{ old('items') }}</textarea>
                @error('items') <p class="text-terra text-xs font-bold mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label class="label">Notes</label>
                <textarea name="notes" class="input" rows="3" placeholder="Optional notes...">{{ old('notes') }}</textarea>
                @error('notes') <p class="text-terra text-xs font-bold mt-1">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="btn-primary w-full justify-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Create Invoice
            </button>
        </form>
    </div>
</div>
@endsection
