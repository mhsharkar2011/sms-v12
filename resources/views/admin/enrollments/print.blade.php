<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrollment Receipt - {{ $enrollment->student->user->name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }

        .school-name {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .receipt-title {
            font-size: 20px;
            margin: 10px 0;
        }

        .section {
            margin: 20px 0;
        }

        .section-title {
            font-size: 18px;
            font-weight: bold;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .info-item {
            margin: 5px 0;
        }

        .label {
            font-weight: bold;
            color: #555;
        }

        .value {
            margin-left: 10px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .table th {
            background-color: #f5f5f5;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }

        .signature-section {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
        }

        .signature-box {
            width: 200px;
            border-top: 1px solid #333;
            padding-top: 10px;
            text-align: center;
        }

        @media print {
            body {
                padding: 0;
            }

            .no-print {
                display: none;
            }

            .container {
                max-width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="school-name">SCHOOL MANAGEMENT SYSTEM</div>
            <div>123 Education Street, City, Country</div>
            <div>Phone: (123) 456-7890 | Email: info@school.edu</div>
            <div class="receipt-title">ENROLLMENT RECEIPT</div>
            <div>Receipt #: ENR-{{ str_pad($enrollment->id, 6, '0', STR_PAD_LEFT) }}</div>
            <div>Date: {{ now()->format('F d, Y') }}</div>
        </div>

        <!-- Student Information -->
        <div class="section">
            <div class="section-title">Student Information</div>
            <div class="info-grid">
                <div class="info-item">
                    <span class="label">Student Name:</span>
                    <span class="value">{{ $enrollment->student->user->name }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Student ID:</span>
                    <span class="value">{{ $enrollment->student->student_id ?? 'N/A' }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Email:</span>
                    <span class="value">{{ $enrollment->student->user->email }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Phone:</span>
                    <span class="value">{{ $enrollment->student->phone ?? 'N/A' }}</span>
                </div>
            </div>
        </div>

        <!-- Class Information -->
        <div class="section">
            <div class="section-title">Class Information</div>
            <div class="info-grid">
                <div class="info-item">
                    <span class="label">Class:</span>
                    <span class="value">{{ $enrollment->class->name }}
                        ({{ $enrollment->class->code }})</span>
                </div>
                <div class="info-item">
                    <span class="label">Grade Level:</span>
                    <span class="value">Grade {{ $enrollment->class->grade_level }} - Section
                        {{ $enrollment->class->section }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Academic Year:</span>
                    <span class="value">{{ $enrollment->class->academic_year }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Teacher:</span>
                    <span class="value">
                        @if ($enrollment->class->teachers->count() > 0)
                            {{ $enrollment->class->teachers->first()->user->name ?? 'Not Assigned' }}
                        @else
                            Not Assigned
                        @endif
                    </span>
                </div>
            </div>
        </div>

        <!-- Enrollment Details -->
        <div class="section">
            <div class="section-title">Enrollment Details</div>
            <div class="info-grid">
                <div class="info-item">
                    <span class="label">Enrollment Date:</span>
                    <span class="value">{{ $enrollment->enrollment_date->format('F d, Y') }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Start Date:</span>
                    <span class="value">{{ $enrollment->start_date->format('F d, Y') }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Status:</span>
                    <span class="value">
                        <span
                            class="badge badge-{{ $enrollment->status === 'enrolled' ? 'success' : ($enrollment->status === 'pending' ? 'warning' : 'secondary') }}">
                            {{ ucfirst($enrollment->status) }}
                        </span>
                    </span>
                </div>
                <div class="info-item">
                    <span class="label">Tuition Fee:</span>
                    <span class="value">${{ number_format($enrollment->tuition_fee, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Payment Information -->
        <!-- Payment Information -->
        @if (method_exists($enrollment, 'payments') && $enrollment->payments->count() > 0)
            <div class="section">
                <div class="section-title">Payment History</div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Status</th>
                            <th>Receipt #</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($enrollment->payments as $payment)
                            <tr>
                                <td>{{ $payment->payment_date->format('M d, Y') }}</td>
                                <td>${{ number_format($payment->amount, 2) }}</td>
                                <td>{{ ucfirst($payment->payment_method) }}</td>
                                <td>
                                    <span
                                        class="badge badge-{{ $payment->status === 'completed' ? 'success' : ($payment->status === 'pending' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                </td>
                                <td>{{ $payment->receipt_number ?? 'N/A' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        @php
                            $totalPaid = $enrollment->payments->where('status', 'completed')->sum('amount');
                            $balance = $enrollment->tuition_fee - $totalPaid;
                        @endphp
                        <tr>
                            <td colspan="4" style="text-align: right; font-weight: bold;">Total Paid:</td>
                            <td style="font-weight: bold;">${{ number_format($totalPaid, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="4" style="text-align: right; font-weight: bold;">Balance:</td>
                            <td style="font-weight: bold;">${{ number_format($balance, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @else
            <div class="section">
                <div class="section-title">Payment Information</div>
                <p>No payments recorded for this enrollment.</p>
                <p>Total Tuition Fee: ${{ number_format($enrollment->tuition_fee ?? 0, 2) }}</p>
            </div>
        @endif

        <!-- Notes -->
        @if ($enrollment->notes)
            <div class="section">
                <div class="section-title">Notes</div>
                <p>{{ $enrollment->notes }}</p>
            </div>
        @endif

        <!-- Signatures -->
        <div class="signature-section">
            <div class="signature-box">
                <div>___________________________</div>
                <div>Student/Parent Signature</div>
            </div>
            <div class="signature-box">
                <div>___________________________</div>
                <div>School Official Signature</div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>This is an official document generated by School Management System</p>
            <p>Generated on: {{ now()->format('F d, Y h:i A') }}</p>
        </div>

        <!-- Print Button (only shows on screen) -->
        <div class="no-print" style="text-align: center; margin-top: 20px;">
            <button onclick="window.print()"
                style="padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">
                Print This Receipt
            </button>
            <button onclick="window.close()"
                style="padding: 10px 20px; background: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer; margin-left: 10px;">
                Close Window
            </button>
        </div>
    </div>

    <script>
        // Auto print when page loads (optional)
        window.onload = function() {
            // Uncomment below to auto-print
            // window.print();
        };
    </script>
</body>

</html>
