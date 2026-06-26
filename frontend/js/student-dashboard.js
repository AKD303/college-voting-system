// Check session on page load
window.addEventListener('load', () => {
    checkSession();
    document.getElementById('userName').textContent = localStorage.getItem('username') || 'Student';
    loadCandidates();
    loadVotingHistory();
});

// Load candidates
function loadCandidates() {
    // Placeholder candidates for 50% completion
    const candidates = [
        { id: 1, name: 'John Doe', position: 'President', votes: 45 },
        { id: 2, name: 'Jane Smith', position: 'Vice President', votes: 38 },
        { id: 3, name: 'Mike Johnson', position: 'Secretary', votes: 32 },
        { id: 4, name: 'Sarah Williams', position: 'Treasurer', votes: 28 }
    ];

    const container = document.getElementById('candidatesContainer');
    container.innerHTML = '';

    candidates.forEach(candidate => {
        const candidateHtml = `
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">${candidate.name}</h5>
                        <p class="card-text">
                            <strong>Position:</strong> ${candidate.position}<br>
                            <strong>Votes:</strong> ${candidate.votes}
                        </p>
                        <button class="btn btn-primary w-100" onclick="voteCandidate(${candidate.id}, '${candidate.name}')">Vote</button>
                    </div>
                </div>
            </div>
        `;
        container.innerHTML += candidateHtml;
    });
}

// Vote for candidate
function voteCandidate(candidateId, candidateName) {
    if (confirm(`Vote for ${candidateName}?`)) {
        // Store vote in localStorage for 50% completion
        let votes = JSON.parse(localStorage.getItem('myVotes') || '[]');
        votes.push({
            candidateId: candidateId,
            candidateName: candidateName,
            date: new Date().toLocaleDateString()
        });
        localStorage.setItem('myVotes', JSON.stringify(votes));
        alert('Vote recorded successfully!');
        loadVotingHistory();
    }
}

// Load voting history
function loadVotingHistory() {
    const votes = JSON.parse(localStorage.getItem('myVotes') || '[]');
    const historyTable = document.getElementById('votingHistory');
    
    if (votes.length === 0) {
        historyTable.innerHTML = '<tr><td colspan="3" class="text-center">No votes yet</td></tr>';
        return;
    }

    historyTable.innerHTML = '';
    votes.forEach(vote => {
        const row = `
            <tr>
                <td>${vote.candidateName}</td>
                <td>Position</td>
                <td>${vote.date}</td>
            </tr>
        `;
        historyTable.innerHTML += row;
    });
}

// Check session
function checkSession() {
    const userId = localStorage.getItem('user_id');
    if (!userId) {
        window.location.href = 'index.html';
    }
}
