import {animate,confetti} from './effects.js';
// Native PHP pages progressively enhanced with the original transitions and interactions.
const main=document.querySelector('main');
const reduced=matchMedia('(prefers-reduced-motion: reduce)').matches;
const cache=new Map();let page=window.EARTHCYCLE.page, navSequence=0, mapModule;
const routes={home:'index.php',locator:'locator.php',guide:'guide.php',materials:'materials.php',products:'products.php',feedback:'feedback.php',faqs:'faq.php'};
const selected='bg-gradient-to-r from-emerald-500 to-teal-500 text-slate-950 font-black shadow-md';
const idle='bg-white/[0.05] text-slate-300 hover:bg-white/[0.1]';
const facilityIdle='border-white/10 hover:border-emerald-500/30 bg-white/[0.03] hover:bg-white/[0.06]';
const facilityActive='border-emerald-400 bg-emerald-500/15 shadow-lg shadow-emerald-950/50 ring-1 ring-emerald-400/40';
let city='All', facility=null;
const centers=window.EARTHCYCLE.centers;
const $=(s,root=document)=>root.querySelector(s), $$=(s,root=document)=>[...root.querySelectorAll(s)];
const fadeIn=el=>!reduced&&el?animate(el,{opacity:[0,1],y:[15,0]},{duration:.3}):null;
function replaceClasses(el,remove,add){el.classList.remove(...remove.split(' '));el.classList.add(...add.split(' '));}
function updateNavigation(){
 const nav=$('header nav'), old=$('[data-nav] > .absolute',nav), oldRect=old?.getBoundingClientRect();
 if(old)old.remove();
 $$('header nav [data-nav]').forEach(el=>{
  const active=el.dataset.nav===page;
  el.className='relative flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold transition-all duration-200 cursor-pointer '+(active?'text-white':'text-slate-400 hover:text-white hover:bg-white/[0.06]');
  el.setAttribute('aria-current',active?'page':'false');
  const icon=$('svg',el);if(icon){icon.classList.toggle('text-emerald-200',active);icon.classList.toggle('text-emerald-400',!active);}
  if(active){const bg=document.createElement('div');bg.className='absolute inset-0 bg-gradient-to-r from-emerald-600 to-teal-600 rounded-xl shadow-lg shadow-emerald-500/20 -z-10';el.prepend(bg);if(oldRect&&!reduced){const rect=bg.getBoundingClientRect();animate(bg,{x:[oldRect.x-rect.x,0],y:[oldRect.y-rect.y,0],scaleX:[oldRect.width/rect.width,1],scaleY:[oldRect.height/rect.height,1]},{type:'spring',stiffness:420,damping:32});}}
 });
 $$('#mobile-menu [data-nav]').forEach(el=>{const active=el.dataset.nav===page;el.className='flex items-center gap-2.5 px-3.5 py-3 rounded-xl text-xs font-bold text-left transition cursor-pointer '+(active?'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md':'text-slate-300 bg-white/[0.04] hover:bg-white/[0.08]');});
}
async function navigate(next,url,push=true){
 if(next===page){closeMenu();return;}
 const seq=++navSequence;
 let content=cache.get(next), title;
 try{
  if(!content){const response=await fetch(url,{headers:{'X-Requested-With':'EarthCycle'}});if(!response.ok)throw Error('Page unavailable');const doc=new DOMParser().parseFromString(await response.text(),'text/html');content=[...doc.querySelector('main').childNodes];title=doc.title;cache.set(next,content);}
  if(seq!==navSequence)return;
  closeMenu();
  if(!reduced)await animate(main.firstElementChild,{opacity:0,y:-15},{duration:page==='home'?.3:.3});
  if(seq!==navSequence)return;
  cache.set(page,[...main.childNodes]);main.replaceChildren(...content);page=next;
  if(push)history.pushState({page},'',url);
  document.title=title||`${$('h1',main)?.textContent?.trim()||'Living Soil Network'} | EarthCycle Gujarat`;
  updateNavigation();window.scrollTo({top:0,behavior:'instant'});initPage();fadeIn(main.firstElementChild);
 }catch(err){if(seq===navSequence)location.assign(url);}
}
let menuAnimation;
function menuIcon(open){$('svg',[...document.querySelectorAll('[data-mobile-toggle]')][0]).innerHTML=open?'<path d="M18 6 6 18M6 6l12 12"></path>':'<path d="M4 6h16M4 12h16M4 18h16"></path>';}
function closeMenu(){const menu=$('#mobile-menu');if(menu.hidden)return;menuAnimation?.stop();$('[data-mobile-toggle]').setAttribute('aria-expanded','false');menuIcon(false);if(reduced){menu.hidden=true;return;}menuAnimation=animate(menu,{height:[menu.offsetHeight,0],opacity:[1,0]},{duration:.3});menuAnimation.then(()=>{menu.hidden=true;menu.style.height='';menu.style.opacity='';});}
function toggleMenu(){const menu=$('#mobile-menu'),open=$('[data-mobile-toggle]').getAttribute('aria-expanded')!=='true';if(!open){closeMenu();return;}menuAnimation?.stop();menu.hidden=false;menu.style.height='';menu.style.opacity='';$('[data-mobile-toggle]').setAttribute('aria-expanded','true');menuIcon(true);if(!reduced){menuAnimation=animate(menu,{height:[0,menu.scrollHeight],opacity:[0,1]},{duration:.3});menuAnimation.then(()=>menu.style.height='');}}
function setGuide(step){
 if(step<1||step>6)return;
 const template=$('#guide-template-'+step);if(!template)return;
 $('#guide-panel').replaceWith(template.content.firstElementChild.cloneNode(true));
 $$('[data-step]',main).filter(el=>!el.closest('#guide-panel')).forEach(el=>{
 const active=Number(el.dataset.step)===step;
 el.className='p-4 rounded-2xl border text-left transition-all cursor-pointer flex flex-col justify-between '+(active?'bg-gradient-to-br from-emerald-600 to-teal-700 text-white border-emerald-400 shadow-xl shadow-emerald-950/60 scale-[1.02]':'bg-white/[0.03] border-white/10 text-slate-300 hover:border-emerald-500/30 hover:bg-white/[0.06]');
 const label=$('span',el);label.classList.toggle('text-emerald-200',active);label.classList.toggle('text-emerald-400',!active);el.setAttribute('aria-pressed',String(active));
 });
}
function filterMaterials(type){
 const root=$('[data-page="materials"]');if(!root)return;
 if(type)root.dataset.filter=type;type=root.dataset.filter||'All';const query=$('#material-search').value.toLowerCase();
 $$('[data-material-filter]',root).forEach(el=>{const cat=el.dataset.materialFilter;el.className='px-4 py-2 rounded-xl text-xs font-bold transition cursor-pointer '+(cat===type?(cat==='Prohibited'?'bg-rose-600 text-white shadow-md':selected):idle);el.setAttribute('aria-pressed',String(cat===type));});
 $$('[data-material]',root).forEach(el=>el.hidden=!((type==='All'||el.dataset.material===type)&&el.dataset.search.toLowerCase().includes(query)));
}
function filteredCenters(){const q=$('#locator-search')?.value.toLowerCase()||'';return centers.filter(c=>(city==='All'||c.city===city)&&(!q||`${c.name} ${c.address} ${c.city} ${c.accepted}`.toLowerCase().includes(q)));}
function syncMap(){window.dispatchEvent(new CustomEvent('earthcycle:map-state',{detail:{city,centers:filteredCenters(),selected:facility}}));}
function selectFacility(center){facility=center;$$('[data-facility]',main).forEach(el=>{replaceClasses(el,facilityIdle+' '+facilityActive,Number(el.dataset.facility)===center?.id?facilityActive:facilityIdle);el.setAttribute('aria-selected',String(Number(el.dataset.facility)===center?.id));});}
function filterFacilities(){
 const list=filteredCenters(),ids=new Set(list.map(c=>c.id));
 $$('[data-facility]',main).forEach(el=>el.hidden=!ids.has(Number(el.dataset.facility)));
 $('#facility-count').textContent=`Showing ${list.length} verified centers`;
 $('#facility-empty').hidden=list.length!==0;
 $$('[data-city]',main).forEach(el=>{el.className='text-xs font-bold px-4 py-2.5 rounded-xl whitespace-nowrap transition cursor-pointer '+(el.dataset.city===city?selected:idle);el.setAttribute('aria-pressed',String(el.dataset.city===city));});syncMap();
}
function setRating(rating){const form=$('#feedback-form');if(!form)return;form.elements.rating.value=rating;$$('[data-rating]',form).forEach(el=>{const on=Number(el.dataset.rating)<=rating;$('svg',el).classList.toggle('text-amber-400',on);$('svg',el).classList.toggle('fill-amber-400',on);$('svg',el).classList.toggle('text-slate-600',!on);el.setAttribute('aria-pressed',String(on));});}
function calculator(){const kg=Number($('#weekly-waste').value),co2=Math.round(kg*52*.92);const values={badge:kg+' kg/wk',weekly:kg+' kg',harvest:Math.round(kg*52*.35),co2,trees:(co2/21).toFixed(1)};for(const[key,value]of Object.entries(values))$(`[data-impact="${key}"]`).textContent=value;}
async function initPage(){
 if(page==='locator'){
  filterFacilities();
  const element=$('#earthcycle-map');if(!element.dataset.mounted){
   mapModule=mapModule||await import('./map.js');
   if(element.isConnected){element.dataset.mounted='true';mapModule.mountMap(element);}
  }
 }
 if(page==='feedback')setRating(Number($('#feedback-form').elements.rating.value));
}
document.addEventListener('click',event=>{
 const nav=event.target.closest('[data-nav]');
 if(nav&&!event.ctrlKey&&!event.metaKey&&!event.shiftKey&&!event.altKey&&event.button===0){event.preventDefault();navigate(nav.dataset.nav,nav.href);return;}
 const toggle=event.target.closest('[data-mobile-toggle]');if(toggle){toggleMenu();return;}
 const step=event.target.closest('[data-step]');if(step&&!step.disabled){setGuide(Number(step.dataset.step));return;}
 const mat=event.target.closest('[data-material-filter]');if(mat){filterMaterials(mat.dataset.materialFilter);return;}
 const cityButton=event.target.closest('[data-city]');if(cityButton){city=cityButton.dataset.city;selectFacility(null);filterFacilities();return;}
 if(event.target.closest('[data-reset-facilities]')){city='All';$('#locator-search').value='';selectFacility(null);filterFacilities();return;}
 const card=event.target.closest('[data-facility]');if(card&&!event.target.closest('a')){selectFacility(centers.find(c=>c.id===Number(card.dataset.facility)));syncMap();return;}
 const faq=event.target.closest('[data-faq]');if(faq){const opening=faq.getAttribute('aria-expanded')!=='true';$$('[data-faq]',main).forEach(el=>{const open=el===faq&&opening;el.setAttribute('aria-expanded',String(open));$('#'+el.getAttribute('aria-controls')).hidden=!open;$('svg',el).classList.toggle('rotate-180',open);});return;}
 const rating=event.target.closest('[data-rating]');if(rating){setRating(Number(rating.dataset.rating));return;}
 if(event.target.closest('[data-pledge]'))confetti({particleCount:110,spread:85,origin:{y:.65},colors:['#10b981','#34d399','#059669','#f59e0b','#38bdf8'],disableForReducedMotion:true});
});
document.addEventListener('input',event=>{
 if(event.target.id==='weekly-waste')calculator();
 if(event.target.id==='material-search')filterMaterials();
 if(event.target.id==='locator-search')filterFacilities();
});
document.addEventListener('submit',async event=>{
 const form=event.target;if(form.id!=='feedback-form')return;event.preventDefault();
 const button=$('[type="submit"]',form),status=$('#feedback-status');button.disabled=true;
 try{
  const response=await fetch(form.action,{method:'POST',body:new FormData(form)});const result=await response.json();
  status.hidden=false;status.textContent=result.message;
  status.className='mb-4 p-3 border rounded-xl text-xs font-medium '+(response.ok?'bg-emerald-500/20 border-emerald-400/40 text-emerald-200':'bg-rose-500/20 border-rose-400/40 text-rose-200');
  if(response.ok){const node=new DOMParser().parseFromString(result.html,'text/html').body.firstElementChild;$('#community-reports h3').after(node);form.elements.name.value='';form.elements.email.value='';form.elements.message.value='';setRating(5);confetti({particleCount:90,spread:75,origin:{y:.6},disableForReducedMotion:true});}
 }catch(err){status.hidden=false;status.textContent='Your report could not be saved. Please try again.';}
 finally{button.disabled=false;}
});
window.addEventListener('popstate',()=>{const file=location.pathname.split('/').pop()||'index.php';const next=Object.keys(routes).find(k=>routes[k]===file)||'home';navigate(next,location.href,false);});
window.addEventListener('earthcycle:map-ready',syncMap);
window.addEventListener('earthcycle:map-selection',event=>selectFacility(event.detail));
window.gm_authFailure=()=>window.dispatchEvent(new CustomEvent('gmp-quota-exceeded'));
const originalError=console.error;console.error=(...args)=>{originalError(...args);const msg=args.map(String).join(' ');if(msg.includes('OverQuotaMapError')||msg.includes('QuotaExceededError'))window.dispatchEvent(new CustomEvent('gmp-quota-exceeded'));};
window.addEventListener('gmp-quota-exceeded',()=>$('#gmpQuotaBanner').hidden=false);
initPage();fadeIn(main.firstElementChild);
