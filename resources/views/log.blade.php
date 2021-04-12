@forelse($activities as $activity)

 {{ $activity->created_at }} {{ $activity->causer->name }} has {{ $activity->description }} {{ class_basename($activity->subject_type) }} {{ $activity->subject->name ?? '' }}
 <br>
@empty

@endforelse
