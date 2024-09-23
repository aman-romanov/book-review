@extends('layouts.app')

@section('content')

  <div class="mb-4">
    <h1 class="mb-2 text-2xl">{{ $book->title }}</h1>

    <div class="book-info">
      <div class="book-author mb-4 text-lg font-semibold">by {{ $book->author }}</div>
      <div class="book-rating flex items-center">
        <div class="mr-2 text-sm font-medium text-slate-700">
          <!-- {{ number_format($book->reviews_avg_rating, 1) }} -->
          <x-star-rating :rating="$book->reviews_avg_rating"/>
        </div>
        <span class="book-review-count text-sm text-gray-500">
          {{ $book->review_count}} {{ Str::plural('review', $book->review_counts) }}
        </span>
      </div>
    </div>
  </div>
  <section x-data="{ flash: true }">
        @if (session()->has('success'))
            <div x-show="flash" class="relative max-h-lg py-2 px-3 mt-3 border-2 p-1 rounded-md border-green-500 bg-green-100 mb-4">
                <strong class="text-sm text-green-800 font-bold">Success!</strong>
                <p class="text-sm text-green-800">{{session('success')}}</p>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" @click="flash = false"
                    stroke="green" class="h-5 w-5 cursor-pointer">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
                </span>
            </div>
        @endif
    </section>
    <div class="mb-4 flex space-x-5">
        <a href="{{ route('book.reviews.create', $book) }}" class="reset-link">
        Add a review!</a>
        <a href="{{ route('book.index') }}" class="reset-link">
        Back</a>
    </div>
  <div>
    <h2 class="mb-4 text-xl font-semibold">Reviews</h2>
    <ul>
      @forelse ($book->reviews as $review)
        <li class="book-item mb-4">
          <div>
            <div class="mb-2 flex items-center justify-between">
              <div class="font-semibold"><x-star-rating :rating="$review->rating"/></div>
              <div class="book-review-count">
                {{ $review->created_at->format('M j, Y') }}</div>
            </div>
            <p class="text-gray-700">{{ $review->review }}</p>
          </div>
        </li>
      @empty
        <li class="mb-4">
          <div class="empty-book-item">
            <p class="empty-text text-lg font-semibold">No reviews yet</p>
          </div>
        </li>
      @endforelse
    </ul>
  </div>
@endsection