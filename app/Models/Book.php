<?php

namespace App\Models;

use App\Models\Review;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;

    public function reviews(){
        return $this->hasMany(Review::class);
    }
    public function scopeTitle(Builder $query, string $title){
        return $query->where('title', 'LIKE', '%' . $title . '%');
    }

    public function scopeReviewCount( Builder $query) : Builder{
        return $query->withCount('reviews');
    }

    public function scopeAverageReview( Builder $query) : Builder{
        return $query->withAvg('reviews', 'rating');
    }

    public function scopePopular(Builder $query, $from = null, $to = null) :Builder {
        return $query->withCount(['reviews' => fn (Builder $q) => $this->dateRangeFilter($q, $from, $to)])->orderBy('reviews_count', 'desc');
    }

    public function scopeHighestRated (Builder $query, $from = null, $to = null) :Builder {
        return $query->withAvg(['reviews' => fn (Builder $q) => $this->dateRangeFilter($q, $from, $to)], 'rating')->orderBy('reviews_avg_rating', 'desc');
    }

    public function scopeMinReviews(Builder $query, int $numReviews) : Builder{
        return $query->having('reviews_count', '>=', $numReviews);
    }

    private function dateRangeFilter(Builder $query, $from, $to){
        if($from && !$to){
            $query->where('created_at', '>=', $from);
        }elseif(!$from && $to){
            $query->where('created_at', '<=', $to);
        }elseif($from && $to){
            $query->whereBetween('created_at' , [$from, $to]);
        }
    }

    public function scopePopularLastMonth( Builder $query) : Builder{
        return $query->popular(now()->subMonth(), now())
                    ->highestRated(now()->subMonth(), now())
                    ->minReviews(3);
    }

    public function scopePopularLast6Months( Builder $query) : Builder{
        return $query->popular(now()->subMonths(6), now())
                    ->highestRated(now()->subMonths(6), now())
                    ->minReviews(10);
    }

    public function scopeHighestRatedLastMonth( Builder $query) : Builder{
        return $query->highestRated(now()->subMonth(), now())
                    ->popular(now()->subMonth(), now())
                    ->minReviews(3);
    }

    public function scopeHighestRatedLast6Months( Builder $query) : Builder{
        return $query->highestRated(now()->subMonths(6), now())
                    ->popular(now()->subMonths(6), now())
                    ->minReviews(10);
    }
}
