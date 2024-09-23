
@extends('layouts.app')

@section('content')
  <h1 class="mb-10 text-2xl">Add Review for {{ $book->title }}</h1>

  <form method="POST" action="{{ route('book.reviews.store', $book) }}">
    @csrf
    <label for="review">Review</label>
    <textarea name="review" id="review" required class="input mb-4">{{old('review')}}</textarea>
    @error('review')
        <p class="ml-7 mb-3 text-sm text-center text-red-600">{{$message}}</p>
    @enderror
    <label for="rating">Rating</label>

    <select name="rating" id="rating" class="input mb-4" required>
      <option value="">Select a Rating</option>
      @for ($i = 1; $i <= 5; $i++)
        <option @if (old('rating') == $i)
            selected
        @endif value="{{ $i }}">{{ $i }}</option>
      @endfor
    </select>
    @error('rating')
        <p class="ml-7 mb-3 text-sm text-center text-red-600">{{$message}}</p>
    @enderror
    <button type="submit" class="btn">Add Review</button>
    <a href="{{ route('book.show', ['book' => $book]) }}" class="reset-link ml-5">
        Back</a>
  </form>
@endsection