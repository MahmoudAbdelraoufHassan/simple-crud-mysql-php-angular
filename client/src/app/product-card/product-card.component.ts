import { ApiService } from './../api/api.service';
import { Component, EventEmitter, Input, Output } from '@angular/core';
import { ToastrService } from 'ngx-toastr';
@Component({
  selector: 'app-product-card',
  standalone: true,
  imports: [],
  templateUrl: './product-card.component.html',
  styleUrl: './product-card.component.css'
})
export class ProductCardComponent {
@Output() id = new EventEmitter<number>();
getId(id: number) {
  this.id.emit(id);
}
@Output() showPopup = new EventEmitter<boolean>();

  @Input() product : any;
  @Output() delete : EventEmitter<number> = new EventEmitter<number>;
  img = 'http://localhost/product_crud/server/';
  constructor(private productApi : ApiService , private toastr : ToastrService){}

  deleteProduct(id : number){
    this.productApi.deleteProduct(id).subscribe((e) =>{
      this.toastr.success(`${e}`);
      this.productApi.getProducts(1).subscribe((e)=>{
        this.delete.emit(e)
      })
    })
  }

show(){
  this.showPopup.emit(true);
}
}
