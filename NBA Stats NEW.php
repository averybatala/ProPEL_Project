function nba_stats_display() {
    ob_start(); ?>
    
    <div class="nba-container">
        <!-- NBA Header with Logo -->
        <div class="nba-header">
            <img src="https://cdn.nba.com/logos/nba/nba-logoman-75-word_white.svg" alt="NBA Logo" class="nba-logo">
            <h1>NBA Team Statistics</h1>
        </div>
        
        <!-- Stats Container -->
        <div class="stats-container">
            <!-- Month Selection -->
            <div class="month-selection">
                <h3><i class="fas fa-calendar-alt"></i> Select Months to Display:</h3>
                <div class="month-checkboxes">
                    <label><input type="checkbox" name="months" value="10-2024" checked> October 2024</label>
                    <label><input type="checkbox" name="months" value="11-2024" checked> November 2024</label>
                    <label><input type="checkbox" name="months" value="12-2024" checked> December 2024</label>
                    <label><input type="checkbox" name="months" value="01-2025" checked> January 2025</label>
                    <label><input type="checkbox" name="months" value="02-2025" checked> February 2025</label>
                    <label><input type="checkbox" name="months" value="03-2025" checked> March 2025</label>
                    <label><input type="checkbox" name="months" value="04-2025" checked> April 2025</label>
                </div>
                <div class="button-group">
                    <button id="loadMonthsBtn" class="nba-button">
                        <i class="fas fa-sync-alt"></i> Load Selected Months
                    </button>
                    <button id="highVisitorBtn" class="nba-button">
                        <i class="fas fa-basketball-ball"></i> Show Highest Visitor Team
                    </button>
                    <button id="monthlyHighVisitorBtn" class="nba-button">
                        <i class="fas fa-chart-line"></i> Show Monthly Visitors
                    </button>
                    <button id="highHomeBtn" class="nba-button">
                        <i class="fas fa-home"></i> Show Highest Home Team
                    </button>
                    <button id="monthlyHighHomeBtn" class="nba-button">
                        <i class="fas fa-calendar-week"></i> Show Monthly Home
                    </button>
                </div>
            </div>
            
            <!-- Loading Indicator -->
            <div id="loadingIndicator" class="loading-indicator" style="display: none;">
                <div class="loading-spinner"></div>
                <span>Crunching numbers...</span>
            </div>
            
            <!-- Answer Box -->
            <div id="answerBox" class="answer-box" style="display:none; margin-bottom: 20px;">
                <div class="answer-header">
                    <i class="fas fa-trophy"></i>
                    <span>TOP PERFORMER</span>
                </div>
                <div class="answer-content">
                    <span id="answerTeam"></span> 
                    <span class="points-badge" id="answerPoints"></span>
                </div>
            </div>
            
            <!-- Monthly Results Container -->
            <div id="monthlyResults" style="display:none; margin-bottom: 20px;">
                <div class="section-header">
                    <i class="fas fa-star"></i>
                    <h3 id="monthlyResultsTitle">Monthly Top Teams</h3>
                </div>
                <div id="monthlyAnswers" class="monthly-grid"></div>
            </div>
            
            <!-- Table Container -->
            <div id="csvResults" class="table-container"></div>
        </div>
    </div>

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
    /* NBA Header Styles */
    .nba-header {
        background: linear-gradient(135deg, #0C2340 0%, #1D428A 100%);
        color: white;
        padding: 30px 20px;
        margin-bottom: 30px;
        text-align: center;
        border-radius: 8px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        position: relative;
        overflow: hidden;
    }
    
    .nba-header:after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle at 70% 50%, rgba(120, 190, 32, 0.2) 0%, transparent 50%);
    }
    
    .nba-logo {
        height: 80px;
        width: auto;
        margin-bottom: 15px;
        filter: drop-shadow(0 0 10px rgba(255, 255, 255, 0.3));
    }
    
    .nba-header h1 {
        margin: 0;
        font-size: 32px;
        font-weight: 700;
        letter-spacing: 1px;
        position: relative;
        z-index: 1;
    }
    
    /* Stats Container */
    .stats-container {
        background: white;
        border-radius: 10px;
        padding: 25px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
    }
    
    /* Loading Indicator Styles */
    .loading-indicator {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 15px;
        padding: 20px;
        margin: 20px 0;
        background: #f8f9fa;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 500;
    }
    
    .loading-spinner {
        width: 25px;
        height: 25px;
        border: 4px solid #f3f3f3;
        border-top: 4px solid #0C2340;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    /* Button group */
    .button-group {
        display: flex;
        gap: 12px;
        margin-top: 20px;
        flex-wrap: wrap;
    }
    
    .nba-container {
        max-width: 100%;
        overflow-x: auto;
        margin: 20px 0;
    }
    
    .month-selection {
        margin-bottom: 25px;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 10px;
    }
    
    .month-selection h3 {
        margin-top: 0;
        color: #0C2340;
        font-size: 18px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .month-checkboxes {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin: 15px 0;
    }
    
    .month-checkboxes label {
        display: flex;
        align-items: center;
        gap: 8px;
        background: white;
        padding: 8px 15px;
        border-radius: 20px;
        transition: all 0.3s ease;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
    
    .month-checkboxes label:hover {
        background: rgba(12, 35, 64, 0.1);
        transform: translateY(-2px);
    }
    
    .nba-table {
        width: 100%;
        border-collapse: collapse;
        margin: 25px 0;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }
    
    .nba-table th, .nba-table td {
        padding: 12px 15px;
        border: 1px solid #ddd;
        text-align: left;
    }
    
    .nba-table th {
        background-color: #0C2340;
        color: white;
        font-weight: 600;
        position: sticky;
        top: 0;
    }
    
    .nba-table tr:nth-child(even) {
        background-color: #f8f9fa;
    }
    
    .nba-table tr:hover {
        background-color: rgba(120, 190, 32, 0.1);
    }
    
    .nba-button {
        padding: 12px 20px;
        background: #78BE20;
        color: #000;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    .nba-button:hover {
        background: #5e9c16;
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }
    
    /* Specific style for the Load Selected Months button */
    #loadMonthsBtn {
        background: #9EA2A2;
        color: #000;
    }
    
    #loadMonthsBtn:hover {
        background: #7E8282;
    }
    
    /* Answer Box */
    .answer-box {
        padding: 0;
        background: linear-gradient(135deg, #0C2340 0%, #1D428A 100%);
        color: white;
        border-radius: 10px;
        display: inline-block;
        overflow: hidden;
        box-shadow: 0 10px 20px rgba(12, 35, 64, 0.2);
    }
    
    .answer-header {
        background: rgba(0, 0, 0, 0.1);
        padding: 12px 20px;
        font-size: 14px;
        font-weight: 600;
        letter-spacing: 1px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .answer-content {
        padding: 20px;
        font-size: 18px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 15px;
    }
    
    .points-badge {
        background: rgba(255, 255, 255, 0.2);
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 16px;
    }
    
    /* Monthly Results */
    .section-header {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #0C2340;
        margin-bottom: 15px;
    }
    
    .monthly-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 15px;
    }
    
    .monthly-answer {
        padding: 15px;
        background: linear-gradient(135deg, #0C2340 0%, #1D428A 100%);
        color: white;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    
    .monthly-answer strong {
        font-size: 16px;
        display: block;
        margin-bottom: 5px;
    }
    
    /* Table container */
    .table-container {
        overflow-x: auto;
        border-radius: 8px;
        margin-top: 20px;
    }
    
    /* Highlight styles for filtered columns */
    .highlight-column {
        background-color: rgba(255, 215, 0, 0.3) !important;
        font-weight: bold;
    }
    
    .highlight-row {
        background-color: rgba(255, 250, 205, 0.5) !important;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .nba-header h1 {
            font-size: 28px;
        }
        
        .nba-logo {
            height: 60px;
        }
        
        .button-group {
            flex-direction: column;
        }
        
        .month-checkboxes {
            flex-direction: column;
        }
        
        .month-checkboxes label {
            width: 100%;
        }
    }
    
    /* Animation for elements */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .stats-container {
        animation: fadeIn 0.6s ease-out forwards;
    }
    </style>

    <script>
    let allData = [];
    let currentFilter = null;

    document.addEventListener('DOMContentLoaded', function() {
        const initialMonths = getSelectedMonths();
        console.log("Initial selected months:", initialMonths);
        loadMonthData(initialMonths);
        
        document.getElementById('loadMonthsBtn').addEventListener('click', function() {
            const selectedMonths = getSelectedMonths();
            console.log("Selected months on button click:", selectedMonths);
            
            if (selectedMonths.length > 0) {
                loadMonthData(selectedMonths);
            } else {
                alert('Please select at least one month');
            }
        });
        
        document.getElementById('highVisitorBtn').addEventListener('click', function() {
            const selectedMonths = getSelectedMonths();
            if (selectedMonths.length === 0) {
                alert('Please select at least one month');
                return;
            }
            
            showLoading(true);
            clearDisplay();
            
            const monthsParam = selectedMonths.join(',');
            const apiPath = `/dev?question=q1&months=${monthsParam}`;
            console.log("API Call:", apiPath);
            
            fetch(`https://dnevampawe.execute-api.us-east-1.amazonaws.com${apiPath}`)
                .then(response => response.json())
                .then(data => {
                    console.log("API Response:", data);
                    const parsed = JSON.parse(data.body);
                    console.log("Parsed Response:", parsed);
                    displaySingleAnswer(parsed.answer.team, parsed.answer.max_value);
                    if (parsed.filtered_rows && parsed.filtered_rows.length > 0) {
                        filterAndDisplayTable(parsed.filtered_rows, 'q1');
                    }
                    showLoading(false);
                })
                .catch(error => {
                    console.error('Error:', error);
                    handleError(error);
                });
        });
        
        document.getElementById('monthlyHighVisitorBtn').addEventListener('click', function() {
            const selectedMonths = getSelectedMonths();
            if (selectedMonths.length === 0) {
                alert('Please select at least one month');
                return;
            }
            
            showLoading(true);
            clearDisplay();
            
            document.getElementById('monthlyResultsTitle').textContent = 'Monthly Highest Visitor Teams:';
            
            // First load all data for the selected months
            const monthsParam = selectedMonths.join(',');
            console.log("Loading full data for months:", monthsParam);
            
            fetch(`https://dnevampawe.execute-api.us-east-1.amazonaws.com/dev?question=full&months=${monthsParam}`)
                .then(response => response.text())
                .then(text => {
                    try {
                        const data = JSON.parse(text);
                        allData = data.body || text;
                        console.log("Full data loaded:", allData);
                    } catch (e) {
                        allData = text;
                    }
                    
                    // Then get monthly highest visitors
                    console.log("Fetching monthly highest visitors...");
                    const promises = selectedMonths.map(month => {
                        const monthApiPath = `/dev?question=q1&months=${month}`;
                        console.log(`Fetching data for month ${month}:`, monthApiPath);
                        
                        return fetch(`https://dnevampawe.execute-api.us-east-1.amazonaws.com${monthApiPath}`)
                            .then(response => response.json())
                            .then(data => {
                                const parsed = JSON.parse(data.body);
                                console.log(`Data for month ${month}:`, parsed);
                                return {
                                    month: month,
                                    team: parsed.answer.team,
                                    points: parsed.answer.max_value,
                                    filtered_rows: parsed.filtered_rows
                                };
                            });
                    });
                    
                    Promise.all(promises)
                        .then(results => {
                            console.log("All monthly results:", results);
                            displayMonthlyResults(results);
                            
                            // Combine all filtered rows from all months
                            const allFilteredRows = results.reduce((acc, result) => {
                                return acc.concat(result.filtered_rows || []);
                            }, []);
                            console.log("Combined filtered rows:", allFilteredRows);
                            
                            if (allFilteredRows.length > 0) {
                                filterAndDisplayTable(allFilteredRows, 'q1');
                            }
                            showLoading(false);
                        })
                        .catch(error => {
                            console.error('Error in monthly promises:', error);
                            handleError(error);
                        });
                })
                .catch(error => {
                    console.error('Error loading full data:', error);
                    handleError(error);
                });
        });
        
        document.getElementById('highHomeBtn').addEventListener('click', function() {
            const selectedMonths = getSelectedMonths();
            if (selectedMonths.length === 0) {
                alert('Please select at least one month');
                return;
            }
            
            showLoading(true);
            clearDisplay();
            
            const monthsParam = selectedMonths.join(',');
            const apiPath = `/dev?question=q2&months=${monthsParam}`;
            console.log("API Call:", apiPath);
            
            fetch(`https://dnevampawe.execute-api.us-east-1.amazonaws.com${apiPath}`)
                .then(response => response.json())
                .then(data => {
                    console.log("API Response:", data);
                    const parsed = JSON.parse(data.body);
                    displaySingleAnswer(parsed.answer.team, parsed.answer.max_value);
                    if (parsed.filtered_rows && parsed.filtered_rows.length > 0) {
                        filterAndDisplayTable(parsed.filtered_rows, 'q2');
                    }
                    showLoading(false);
                })
                .catch(error => {
                    console.error('Error:', error);
                    handleError(error);
                });
        });
        
        document.getElementById('monthlyHighHomeBtn').addEventListener('click', function() {
            const selectedMonths = getSelectedMonths();
            if (selectedMonths.length === 0) {
                alert('Please select at least one month');
                return;
            }
            
            showLoading(true);
            clearDisplay();
            
            document.getElementById('monthlyResultsTitle').textContent = 'Monthly Highest Home Teams:';
            
            // First load all data for the selected months
            const monthsParam = selectedMonths.join(',');
            console.log("Loading full data for months:", monthsParam);
            
            fetch(`https://dnevampawe.execute-api.us-east-1.amazonaws.com/dev?question=full&months=${monthsParam}`)
                .then(response => response.text())
                .then(text => {
                    try {
                        const data = JSON.parse(text);
                        allData = data.body || text;
                        console.log("Full data loaded:", allData);
                    } catch (e) {
                        allData = text;
                    }
                    
                    // Then get monthly highest home teams
                    console.log("Fetching monthly highest home teams...");
                    const promises = selectedMonths.map(month => {
                        const monthApiPath = `/dev?question=q2&months=${month}`;
                        console.log(`Fetching data for month ${month}:`, monthApiPath);
                        
                        return fetch(`https://dnevampawe.execute-api.us-east-1.amazonaws.com${monthApiPath}`)
                            .then(response => response.json())
                            .then(data => {
                                const parsed = JSON.parse(data.body);
                                console.log(`Data for month ${month}:`, parsed);
                                return {
                                    month: month,
                                    team: parsed.answer.team,
                                    points: parsed.answer.max_value,
                                    filtered_rows: parsed.filtered_rows
                                };
                            });
                    });
                    
                    Promise.all(promises)
                        .then(results => {
                            console.log("All monthly results:", results);
                            displayMonthlyResults(results);
                            
                            // Combine all filtered rows from all months
                            const allFilteredRows = results.reduce((acc, result) => {
                                return acc.concat(result.filtered_rows || []);
                            }, []);
                            console.log("Combined filtered rows:", allFilteredRows);
                            
                            if (allFilteredRows.length > 0) {
                                filterAndDisplayTable(allFilteredRows, 'q2');
                            }
                            showLoading(false);
                        })
                        .catch(error => {
                            console.error('Error in monthly promises:', error);
                            handleError(error);
                        });
                })
                .catch(error => {
                    console.error('Error loading full data:', error);
                    handleError(error);
                });
        });
    });

    // Helper Functions
    function displaySingleAnswer(team, points) {
        console.log("Displaying single answer:", team, points);
        document.getElementById('answerTeam').textContent = team;
        document.getElementById('answerPoints').textContent = points;
        document.getElementById('answerBox').style.display = 'block';
    }

    function displayMonthlyResults(results) {
        console.log("Displaying monthly results:", results);
        const monthlyAnswers = document.getElementById('monthlyAnswers');
        monthlyAnswers.innerHTML = '';
        
        results.forEach(result => {
            const monthDiv = document.createElement('div');
            monthDiv.className = 'monthly-answer';
            monthDiv.innerHTML = 
                `<strong>${formatMonth(result.month)}:</strong> 
                ${result.team} (${result.points} points)`;
            monthlyAnswers.appendChild(monthDiv);
        });
        
        document.getElementById('monthlyResults').style.display = 'block';
    }

    function filterAndDisplayTable(filteredRows, questionType) {
        console.log("Filtering and displaying table:", filteredRows, questionType);
        // Convert filtered rows to CSV format
        let csvContent = '';
        
        if (filteredRows.length > 0) {
            const headers = Object.keys(filteredRows[0]);
            csvContent = headers.join(',') + '\n';
            
            filteredRows.forEach(row => {
                const values = headers.map(header => row[header]);
                csvContent += values.join(',') + '\n';
            });
        }
        
        renderCsvTable(csvContent);
        highlightColumn(questionType);
    }

    function highlightColumn(questionType) {
        console.log("Highlighting column for question type:", questionType);
        // Remove existing highlights
        document.querySelectorAll('.highlight-column, .highlight-row').forEach(el => {
            el.classList.remove('highlight-column', 'highlight-row');
        });
        
        const headerCells = document.querySelectorAll('.nba-table th');
        headerCells.forEach(cell => {
            if ((questionType === 'q1' && cell.textContent.includes('Visitor')) ||
                (questionType === 'q2' && cell.textContent.includes('Home'))) {
                cell.classList.add('highlight-column');
                
                const index = Array.from(cell.parentNode.children).indexOf(cell);
                document.querySelectorAll(`.nba-table tr td:nth-child(${index + 1})`).forEach(td => {
                    td.classList.add('highlight-column');
                });
            }
        });
    }

    function clearDisplay() {
        console.log("Clearing display");
        document.getElementById('answerBox').style.display = 'none';
        document.getElementById('monthlyResults').style.display = 'none';
        document.getElementById('csvResults').innerHTML = '';
    }

    function handleError(error) {
        console.error('Error:', error);
        document.getElementById('csvResults').innerHTML = 
            '<p>Error loading data. Please try again later.</p>';
        showLoading(false);
    }

    function formatMonth(monthStr) {
        const [month, year] = monthStr.split('-');
        const monthNames = ["January", "February", "March", "April", "May", "June",
                          "July", "August", "September", "October", "November", "December"];
        return `${monthNames[parseInt(month) - 1]} ${year}`;
    }

    function showLoading(show) {
        console.log("Show loading:", show);
        document.getElementById('loadingIndicator').style.display = show ? 'flex' : 'none';
    }

    function getSelectedMonths() {
        const months = Array.from(document.querySelectorAll('input[name="months"]:checked'))
            .map(checkbox => checkbox.value);
        console.log("Selected months:", months);
        return months;
    }

    function loadMonthData(months) {
        console.log("Loading month data for:", months);
        if (months.length === 0) {
            alert('Please select at least one month');
            return;
        }
        
        showLoading(true);
        clearDisplay();
        
        const monthsParam = months.join(',');
        const apiPath = `/dev?question=full&months=${monthsParam}`;
        console.log("Full data API call:", apiPath);
        
        fetch(`https://dnevampawe.execute-api.us-east-1.amazonaws.com${apiPath}`)
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.text();
            })
            .then(text => {
                try {
                    const data = JSON.parse(text);
                    allData = data.body || text;
                    console.log("Received full data:", allData);
                } catch (e) {
                    allData = text;
                }
                renderCsvTable(allData);
                showLoading(false);
            })
            .catch(error => {
                console.error('Error loading month data:', error);
                handleError(error);
            });
    }

    function renderCsvTable(csvText) {
        console.log("Rendering CSV table");
        const rows = csvText.split('\n').filter(row => row.trim() !== '');
        if (rows.length < 2) {
            document.getElementById('csvResults').innerHTML = 
                '<p>No data available for selected months</p>';
            return;
        }

        const headers = rows[0].split(',');
        const ptsVisitorIdx = headers.indexOf('PTS_Visitor');
        const ptsHomeIdx = headers.indexOf('PTS_Home');
        const attendIdx = headers.indexOf('Attend.');

        let html = '<table class="nba-table"><thead>';
        html += '<tr>' + headers.map(col => '<th>' + col + '</th>').join('') + '</tr></thead><tbody>';

        for (let i = 1; i < rows.length; i++) {
            const cols = rows[i].split(',');
            const rowHtml = cols.map((col, index) => {
                if ([ptsVisitorIdx, ptsHomeIdx, attendIdx].includes(index)) {
                    const num = parseFloat(col);
                    return '<td>' + (isNaN(num) ? col : Math.round(num)) + '</td>';
                }
                return '<td>' + col + '</td>';
            }).join('');
            html += '<tr>' + rowHtml + '</tr>';
        }

        html += '</tbody></table>';
        document.getElementById('csvResults').innerHTML = html;
    }
    </script>
    
    <?php
    return ob_get_clean();
}
add_shortcode('nba_stats_display', 'nba_stats_display');