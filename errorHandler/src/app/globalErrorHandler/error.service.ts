
import { Injectable } from '@angular/core';
import { errors } from '../custumSelectors/errors.selector';

@Injectable({
    providedIn: 'root'
})
export class ErrorService {
    getCustomErrorMessage(status: number ): string {
        return errors[status] ? errors[status] : 'Unknown Error';
    }
}