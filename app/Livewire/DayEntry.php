<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Day;
use Illuminate\Support\Facades\Auth;

class DayEntry extends Component
{
    public $date;
    public $weight;
    public $exercise_rung;
    public $notes;
    public $trend;
    public $variation;
    public $day;
    public $displayWeight;
    public $is_editable;

    public function mount($day)
    {
        $this->day = $day;
        $this->date = $day['date'];
        $this->weight = $day['weight'] ? (float)str_replace(',', '', $day['weight']) : null;
        $this->displayWeight = $day['weight']; // Keep formatted version for display
        $this->exercise_rung = $day['exercise_rung'];
        $this->notes = $day['notes'];
        $this->trend = $day['trend'];
        $this->variation = $day['variation'];
        $this->is_editable = $day['is_editable'];
    }

    public function updated($field, $value)
    {
        try {
            $value = $this->{$field};
            
            // Convert string numbers back to floats for weight
            if ($field === 'weight' && !is_null($value)) {
                $value = (float)$value;
            }

            if ($field === 'exercise_rung' || $field === 'weight') {
                $value = $value == '' ? null : $value;
            }

            Day::updateOrCreate(
                [
                    'date' => $this->date,
                    'user_id' => Auth::id()
                ],
                [$field => $value]
            );

            // Update the display weight after saving
            if ($field === 'weight' && !is_null($value)) {
                $this->displayWeight = floor($value) == $value 
                    ? number_format($value, 0) 
                    : number_format($value, 1);
                
                // Emit an event to trigger trend recalculation
                $this->dispatch('weightUpdated');
            }

        } catch (\Exception $e) {
            logger()->error('Error updating day', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    public function render()
    {
        return view('livewire.day-entry');
    }
}
