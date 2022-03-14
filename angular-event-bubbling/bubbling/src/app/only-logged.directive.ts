import { Directive, ElementRef, HostListener, Input } from '@angular/core';
import { fromEvent, Subscription } from 'rxjs';

@Directive({
    selector: '[onlyLogged]'
})
export class OnlyLoggedDirective {
    sub = new Subscription();
    logged: boolean = false;

    constructor(private elRef: ElementRef) {}

    ngOnInit() {
        const el = this.elRef.nativeElement;
        this.sub = fromEvent(el.parentNode, 'click', { capture: true})
        .subscribe( (ev: any) => {
            console.log(el.parentNode)
            console.log(el)
            console.log(ev.target)
            if(ev.target == el) { this.checkLogin(ev); }
        })
    }

    checkLogin(ev: any) {
        if(!this.logged) {
            console.log("user is not logged in", );
            ev.stopImmediatePropagation();
            this.openLogin(ev);
        } else {
            console.log("user is logged in"); 
        }
    }

    openLogin(ev: any) {
        console.log('onDidDismiss resolved with role');
    }
}