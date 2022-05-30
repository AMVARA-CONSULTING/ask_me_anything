import { HttpErrorResponse } from "@angular/common/http";
import { ErrorHandler, Injectable, Injector } from "@angular/core";
import { ErrorService } from "./error.service";
import { MatSnackBar } from '@angular/material/snack-bar';
import { NgZone } from "@angular/core";

@Injectable()
export class GlobalErrorHandler implements ErrorHandler {
    errorService: any = null;

    constructor(private injector: Injector, private snackbar: MatSnackBar, private zone: NgZone) {
        this.errorService = this.injector.get(ErrorService);
    }

    handleError(error: any): void {
        this.handle(error);
    }

    private handle(error: any) {
        const notification = this.getNotification(error);
        this.log(error);
        this.notify(notification);
    }


    private notify(notification: any) {
        this.zone.run(() => notification )
    }

    private getNotification(error: any) {
        const userMessage = this.getUserFriendlyMessage(error);
        return this.snackbar.open("Oops,", userMessage, {duration: 3000})
    }

    private log(error: any) {
        const techMessage = this.technicalMessage(error);
        const customeErrorMessage = this.errorService.getCustomErrorMessage(error.status);
        console.log(techMessage, customeErrorMessage, error)
        console.log("")
    }

    private getUserFriendlyMessage(error: any) {
        return error instanceof HttpErrorResponse ? 'Could not get the data': 'Not http Error';
    }

    private technicalMessage(error: any) {
        return error instanceof HttpErrorResponse ? <any>error.url: 'Something went wrong in the program';
    }
}
