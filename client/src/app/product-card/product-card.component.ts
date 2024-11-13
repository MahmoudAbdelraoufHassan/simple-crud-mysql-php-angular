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
  @Input() product : any;
  @Output() delete : EventEmitter<number> = new EventEmitter<number>;
  img = 'http://localhost/product_crud/server/';
  constructor(private productApi : ApiService , private toastr : ToastrService){}

  deleteProduct($id : number){
    this.delete?.emit($id);
    this.productApi.deleteProduct($id).subscribe((e) =>{
      this.toastr.success(`${e}`);
    })
  }
}
