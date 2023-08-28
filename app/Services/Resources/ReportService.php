<?php

namespace App\Services\Resources;

use App\Enums\Period;
use App\Models\Report;
use App\Services\UploadService;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Barryvdh\DomPDF\PDF as DomPDF;
use Carbon\Carbon;

class ReportService
{
    public function __construct(
        protected UploadService                              $uploadService,
        protected \App\Services\Reporting\RequestableService $requestableService,
        protected \App\Services\Reporting\AdvertService      $advertService,
        protected \App\Services\Reporting\BookingService     $bookingService,
        protected \App\Services\Reporting\TicketService      $ticketService
    )
    {
    }

    /**
     * If a report exits for the given period and hall don't allow the user to generate a new one
     *
     * @param Period $period
     * @param int $hall
     * @return bool
     */
    public function checkIfReportExists(Period $period, int $hall): bool
    {
        $date = $this->generateStartDate($period);

        return Report::forHall($hall)
            ->forDatePeriod($date, $period)
            ->exists();
    }


    /**
     * Generates a report, uploads it, persists metadata and returns it ready for streaming
     * Acts as an access point for the other methods
     *
     * @param Period $period
     * @param int $hall
     * @param string $text
     * @return DomPDF
     */
    public function generateReport(Period $period, int $hall, string $text): DomPDF
    {
        //Generate, upload
        $PDF = $this->generatePDF($period, $hall, $text);
        $date_from = $this->generateStartDate($period);
        $PDF_path = $this->uploadService->uploadPDF($PDF, 'reports/' . $period->value . '/' . $hall . '_' . now()->format('Y-m-d_H-i') . '.pdf');

        //Persist metadata
        Report::create([
            'period' => $period,
            'hall_id' => $hall,
            'text' => $text,
            'date_from' => $date_from,
            'user_id' => auth()->user()->id,
            'created_at' => now(),
            'PDF_path' => $PDF_path
        ]);

        //Return the PDF file for streaming
        return $PDF;
    }

    /**
     * Builds and returns a DomPDF object ready for storing/streaming
     *
     * @param Period $period
     * @param int $hall
     * @param string $text
     * @return DomPDF
     */
    private function generatePDF(Period $period, int $hall, string $text): DomPDF
    {
        list($request_data, $advert_data, $booking_data, $ticket_data, $dates) = $this->buildReportData($period, $hall);

        return PDF::loadView('pdf.report', [
            'period' => $period->toSrLatinString(),
            'date' => $this->formatForPDF($this->generateStartDate($period), $period),
            'hall' => $hall,
            'text' => $text,
            'request_data' => $request_data,
            'advert_data' => $advert_data,
            'booking_data' => $booking_data,
            'ticket_data' => $ticket_data,
            'dates' => $dates,
            'manager' => auth()->user()
        ]);
    }

    /**
     * Formats a date to an appropriate string format for a PDF report
     *
     * @param Carbon $date
     * @param Period $period
     * @return string
     */
    private function formatForPDF(Carbon $date, Period $period): string
    {
        return match ($period) {
            Period::YEARLY => $date->format('Y'),
            Period::MONTHLY => $date->format('m/Y'),
            Period::WEEKLY => $date->format('m/d/y'),
        };
    }


    /**
     * Generates a start date for a report based on the period
     *
     * @param Period $period
     * @return Carbon
     */
    private function generateStartDate(Period $period): Carbon
    {
        return match ($period) {
            Period::YEARLY => now()->subYear()->startOfYear(),
            Period::MONTHLY => now()->subMonth()->startOfMonth(),
            Period::WEEKLY => now()->subWeek()->startOfWeek(),
        };
    }

    /**
     *  Gathers data from all reporting services and returns it in an array
     *
     * @param Period $period
     * @param int $hall
     * @return array
     */
    private function buildReportData(Period $period, int $hall): array
    {
        $request_data = $this->requestableService->getReportableDataByPeriod($period, $hall);
        $advert_data = $this->advertService->getReportableDataByPeriod($period, $hall);
        $booking_data = $this->bookingService->getReportableDataByPeriod($period, $hall);
        $ticket_data = $this->ticketService->getReportableDataByPeriod($period, $hall);

        $dates = array_keys(array_intersect_key($advert_data, $booking_data, $ticket_data));

        return [$request_data, $advert_data, $booking_data, $ticket_data, $dates];

    }


}
