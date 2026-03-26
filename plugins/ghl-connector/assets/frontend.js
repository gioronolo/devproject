(function(){
    document.addEventListener('DOMContentLoaded', function(){
        document.querySelectorAll('.ghl-popup-overlay').forEach(function(overlay){
            var trigger   = overlay.dataset.trigger   || 'onload';
            var animation = overlay.dataset.animation || 'slideUp';
            var duration  = parseFloat(overlay.dataset.duration) || 0.35;
            var reshow    = parseInt(overlay.dataset.reshow)      || -1;
            var id        = overlay.id;
            var storageKey = 'ghl_popup_' + id;

            // Check if should show
            if(reshow === -1){ /* always show */ }
            else if(reshow === 0){ if(sessionStorage.getItem(storageKey)) return; }
            else { var last = localStorage.getItem(storageKey); if(last){ var diff=(Date.now()-parseInt(last))/(1000*60*60*24); if(diff<reshow) return; } }

            function showPopup(){
                overlay.style.display = 'flex';
                var panel = overlay.querySelector('.ghl-popup-panel');
                if(panel){ panel.style.transition = 'transform '+duration+'s ease, opacity '+duration+'s ease'; }
                if(animation==='slideUp'){ panel.style.transform='translateY(40px)';panel.style.opacity='0';setTimeout(function(){panel.style.transform='translateY(0)';panel.style.opacity='1';},10); }
                else if(animation==='slideDown'){ panel.style.transform='translateY(-40px)';panel.style.opacity='0';setTimeout(function(){panel.style.transform='translateY(0)';panel.style.opacity='1';},10); }
                else if(animation==='fadeIn'){ panel.style.opacity='0';setTimeout(function(){panel.style.opacity='1';},10); }
                else if(animation==='zoomIn'){ panel.style.transform='scale(0.85)';panel.style.opacity='0';setTimeout(function(){panel.style.transform='scale(1)';panel.style.opacity='1';},10); }
            }

            function hidePopup(permanent){
                overlay.style.display='none';
                if(permanent){ localStorage.setItem(storageKey, 'hidden'); }
                else if(reshow===0){ sessionStorage.setItem(storageKey,'1'); }
                else if(reshow>0){ localStorage.setItem(storageKey, Date.now().toString()); }
            }

            // Close button
            var closeBtn = overlay.querySelector('.ghl-popup-close');
            if(closeBtn) closeBtn.addEventListener('click', function(){ hidePopup(false); });

            // Close on overlay click
            overlay.addEventListener('click', function(e){ if(e.target===overlay) hidePopup(false); });

            // Trigger
            if(trigger==='onload') setTimeout(showPopup, 300);
            else if(trigger==='exit'){ document.addEventListener('mouseleave', function(e){ if(e.clientY<10) showPopup(); }, {once:true}); }
        });
    });
})();
