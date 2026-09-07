const $=id=>document.getElementById(id);
const money=n=>'UGX '+Number(n||0).toLocaleString();
let history=JSON.parse(localStorage.getItem('ykEggsHistory')||'[]');

function save(){localStorage.setItem('ykEggsHistory',JSON.stringify(history));}
function toast(msg){$('toast').textContent=msg;$('toast').classList.add('show');setTimeout(()=>$('toast').classList.remove('show'),2200)}
function calculate(e){
 e.preventDefault();
 const trays=+$('trays').value, eggs=+$('eggsPerTray').value, cost=+$('costPerTray').value;
 const sell=+$('sellPerTray').value, transport=+$('transport').value||0, other=+$('otherCosts').value||0;
 const revenue=trays*sell, stockCost=trays*cost, totalCost=stockCost+transport+other;
 const profit=revenue-totalCost, margin=revenue?profit/revenue*100:0, totalEggs=trays*eggs;
 const item={id:Date.now(),date:new Date().toISOString(),customer:$('customer').value||'Walk-in',region:$('region').value,trays,eggsPerTray:eggs,costPerTray:cost,sellPerTray:sell,transport,otherCosts,revenue,totalCost,profit,margin,totalEggs};
 history.unshift(item);history=history.slice(0,200);save();renderResults(item);renderHistory();renderDashboard();toast('Calculation saved');
}
function renderResults(x){
 $('results').classList.remove('hidden');
 $('results').innerHTML=`
 <div class="metric"><span>Total eggs</span><strong>${x.totalEggs.toLocaleString()}</strong></div>
 <div class="metric"><span>Total sales / revenue</span><strong>${money(x.revenue)}</strong></div>
 <div class="metric"><span>Total cost</span><strong>${money(x.totalCost)}</strong></div>
 <div class="metric ${x.profit>=0?'profit':'loss'}"><span>${x.profit>=0?'Estimated profit':'Estimated loss'}</span><strong>${money(x.profit)}</strong><div class="muted">Margin: ${x.margin.toFixed(2)}%</div></div>`;
}
function renderHistory(){
 const el=$('historyList');
 if(!history.length){el.innerHTML='<div class="empty">No calculations yet.</div>';return}
 el.innerHTML=history.map(x=>`<div class="history-item">
 <div class="history-top"><span>${x.customer}</span><span>${money(x.profit)}</span></div>
 <div class="muted">${x.region} • ${x.trays} trays • ${new Date(x.date).toLocaleString()}</div>
 <div class="muted">Revenue ${money(x.revenue)} • Cost ${money(x.totalCost)} • Margin ${x.margin.toFixed(1)}%</div></div>`).join('');
}
function renderDashboard(){
 const revenue=history.reduce((a,x)=>a+x.revenue,0), profit=history.reduce((a,x)=>a+x.profit,0);
 const trays=history.reduce((a,x)=>a+x.trays,0), avg=history.length?profit/history.length:0;
 $('dashboardStats').innerHTML=`
 <div class="stat"><span>Calculations</span><strong>${history.length}</strong></div>
 <div class="stat"><span>Total trays</span><strong>${trays.toLocaleString()}</strong></div>
 <div class="stat"><span>Total revenue</span><strong>${money(revenue)}</strong></div>
 <div class="stat"><span>Total profit</span><strong>${money(profit)}</strong></div>`;
 $('recentList').innerHTML=history.slice(0,5).map(x=>`<div class="history-item"><b>${x.customer}</b><div class="muted">${x.region} • ${x.trays} trays • ${money(x.profit)} profit</div></div>`).join('')||'<div class="empty">No recent calculations.</div>';
}
$('calcForm').addEventListener('submit',calculate);
$('resetBtn').addEventListener('click',()=>{$('calcForm').reset();$('trays').value=10;$('eggsPerTray').value=30;$('transport').value=0;$('otherCosts').value=0;$('results').classList.add('hidden')});
$('clearHistory').addEventListener('click',()=>{if(confirm('Delete all calculation history?')){history=[];save();renderHistory();renderDashboard();toast('History cleared')}});
document.querySelectorAll('.tab').forEach(btn=>btn.addEventListener('click',()=>{document.querySelectorAll('.tab').forEach(x=>x.classList.remove('active'));document.querySelectorAll('.page').forEach(x=>x.classList.remove('active'));btn.classList.add('active');$(btn.dataset.page).classList.add('active')}));
renderHistory();renderDashboard();

if('serviceWorker' in navigator) navigator.serviceWorker.register('./service-worker.js').catch(console.error);
let deferredPrompt;
window.addEventListener('beforeinstallprompt',e=>{e.preventDefault();deferredPrompt=e;$('installBtn').classList.remove('hidden')});
$('installBtn').addEventListener('click',async()=>{if(!deferredPrompt)return;deferredPrompt.prompt();await deferredPrompt.userChoice;deferredPrompt=null;$('installBtn').classList.add('hidden')});