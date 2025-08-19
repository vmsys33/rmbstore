# Sales Summary Feature

## Overview
The Sales Summary feature provides comprehensive reporting and analytics for daily sales data based on the `daily_closings` table. This feature allows administrators to view, search, and export sales summary data with detailed insights.

## Features

### 🎯 Core Functionality
- **Daily Sales Summary Table**: View all daily closing records with comprehensive data
- **Top Sales Ranking**: Show top performing days by sales volume
- **Date Range Search**: Filter data by custom date ranges
- **Sales Details Preview**: Click the eye icon to view individual sales for a specific date
- **Statistics Dashboard**: Real-time summary statistics with visual cards
- **CSV Export**: Download data for external analysis

### 📊 Data Displayed
- **Date**: Closing date
- **Cash Management**: Opening cash, closing cash, cash shortage
- **Sales Breakdown**: Cash, card, bank transfer, and online sales
- **Transaction Metrics**: Total sales, transactions, items sold
- **Financial Details**: Discounts, taxes, total amounts
- **User Information**: Who closed the day and when
- **Notes**: Additional closing notes

### 🔍 Search & Filter Options
- **Date Range**: Select start and end dates
- **Top Records**: Choose to show top 5, 10, 20, or 50 days
- **Show All**: Toggle to display all records in the date range
- **Real-time Updates**: Statistics update automatically with search

## How to Use

### 1. Access the Feature
- Navigate to **Admin Panel** → **Sales Summary** in the sidebar
- The page will load with current month's data by default

### 2. View Data
- **Statistics Cards**: See summary metrics at the top
- **Main Table**: Browse daily closing records
- **Responsive Design**: Works on desktop and mobile devices

### 3. Search & Filter
- Set **Start Date** and **End Date** for your desired period
- Choose **Show Top** option (5, 10, 20, 50) or check **Show All**
- Click **Search** to apply filters
- Use **Refresh** to reload current data

### 4. View Sales Details
- Click the **👁️ (eye)** icon in the Actions column
- Modal opens showing all individual sales for that date
- View customer details, payment methods, amounts, and timestamps

### 5. Export Data
- Click **Export CSV** button
- File downloads with filename: `sales_summary_YYYY-MM-DD_to_YYYY-MM-DD.csv`
- Includes all visible data in the current search results

## Technical Details

### Database Tables Used
- **`daily_closings`**: Main source of summary data
- **`users`**: User information for who closed each day
- **`sales`**: Individual sale records for detailed views

### API Endpoints
- `GET /admin/sales-summary` - Main page
- `GET /admin/sales-summary/getData` - AJAX data retrieval
- `GET /admin/sales-summary/getSalesDetails/{date}` - Sales details for a date
- `GET /admin/sales-summary/getStats` - Summary statistics
- `GET /admin/sales-summary/exportCsv` - CSV export

### Key Features
- **Mobile Responsive**: Touch-friendly interface
- **Real-time Updates**: Live data without page refresh
- **Error Handling**: Graceful error messages and fallbacks
- **Performance Optimized**: Efficient database queries with joins
- **Currency Support**: Dynamic currency symbols from settings

## Requirements

### Prerequisites
- Daily closing data must exist in the `daily_closings` table
- Users table must have `first_name` and `last_name` fields
- Sales data must be properly linked to daily closings

### Browser Support
- Modern browsers with ES6+ support
- Bootstrap 5 CSS framework
- SweetAlert2 for notifications

## Troubleshooting

### Common Issues
1. **No Data Displayed**: Check if daily closings exist for the selected date range
2. **Sales Details Not Loading**: Verify the sales table has data for the selected date
3. **Export Fails**: Ensure proper permissions and check browser download settings

### Error Messages
- **"No data found"**: No daily closings exist for the selected period
- **"Error loading data"**: Check server logs for database connection issues
- **"Error loading sales details"**: Verify sales data exists for the selected date

## Future Enhancements

### Planned Features
- **Charts & Graphs**: Visual representation of sales trends
- **Comparative Analysis**: Year-over-year or month-over-month comparisons
- **Advanced Filtering**: Filter by user, payment method, or sales range
- **Real-time Notifications**: Alerts for exceptional sales days
- **Email Reports**: Automated daily/weekly summary emails

### Customization Options
- **Custom Date Formats**: Support for different regional date formats
- **Additional Metrics**: Custom KPIs and business-specific calculations
- **Export Formats**: PDF, Excel, and other export options
- **Scheduled Reports**: Automated report generation

## Support

For technical support or feature requests, please contact the development team or create an issue in the project repository.

---

**Last Updated**: <?= date('Y-m-d') ?>
**Version**: 1.0.0
**Compatibility**: CodeIgniter 4.x, PHP 7.4+
