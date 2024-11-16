import { Component, EventEmitter, Input, Output } from '@angular/core';
import { NgClass } from '@angular/common';

@Component({
  selector: 'app-view-product',
  standalone: true,
  imports: [NgClass],
  templateUrl: './view-product.component.html',
  styleUrl: './view-product.component.css'
})
export class ViewProductComponent {
@Input() Data !: any;
@Input() show !:boolean;
@Output() closeView = new EventEmitter<boolean>()
img = 'http://localhost/product_crud/server/';

closeViewproduct(){
  this.show = false;
this.closeView.emit(false)
}

}
