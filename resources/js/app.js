// import '../js/bootstrap';

function openModal(domain, expiry) {
  document.getElementById('trackDomainHidden').value = domain;
  document.getElementById('trackExpiryHidden').value = expiry;
  document.getElementById('trackModal').style.display = 'block';
}

function closeModal() {
  document.getElementById('trackModal').style.display = 'none';
}

// No need for JavaScript form submission — the form will submit normally




// async function loadTrackedDomains() {
//   const res = await fetch('/api/tracked');
//   const list = await res.json();
//   const container = document.getElementById('tracked');

//     if (list.length === 0) {
//     container.innerHTML = `
//       <p style="color: black; font-style: italic;text-align:center;">No domain to track</p>
//     `;
//     return;
//   }

//   container.innerHTML = list.map(d =>
//     `<p style="display:flex;margin-left:20px">${d.domain} - expires on ${new Date(d.expiry).toDateString()}
//      <p>${d.days}</p>
//      <button class="btn-3" onclick="untrack('${d.domain}')">-</button></p>`
//   ).join('');
// }

// async function untrack(domain) {
//   await fetch(`/api/tracked/${domain}`, { method: 'DELETE' });
//   loadTrackedDomains();
// }






// function saveToLocal(domain, data) {
//   const history = JSON.parse(localStorage.getItem("searchHistory")) || [];
//   history.unshift({ domain, data, time: new Date().toLocaleString() });
//   localStorage.setItem("searchHistory", JSON.stringify(history));
//   console.log("Saving to history:", history);
//   displayHistory();
// }

// function displayHistory() {
//   const history = JSON.parse(localStorage.getItem("searchHistory")) || [];
//   console.log("Loaded history:", history);
//   const historyEl = document.getElementById('history');

//     if (history.length === 0) {
//     historyEl.innerHTML = `
//       <h3>Search History</h3>
//       <p style="color: grey; font-style: italic;">No search history</p>
//     `;
//     return;
//   }



//   const latestHistory = history.slice(0,10);

//   historyEl.innerHTML = `<h3 >Search History</h3>` + latestHistory.map(item =>
//     `<p style="text-align:center;"><strong>${item.domain}</strong> - ${item.time}</p>`
//   ).join("");
  
// }


// displayHistory();
// loadTrackedDomains();
