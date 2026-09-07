const express=require('express');
const cors=require('cors');
const pool=require('./db');
require('dotenv').config();
const app=express();
app.use(cors()); app.use(express.json());

app.get('/api/health',async(req,res)=>{
 try{await pool.query('SELECT 1');res.json({ok:true,service:'YK Eggs API'})}
 catch(e){res.status(500).json({ok:false,error:e.message})}
});

app.post('/api/calculations',async(req,res)=>{
 try{
  const x=req.body;
  const revenue=Number(x.trays)*Number(x.sellPerTray);
  const totalCost=Number(x.trays)*Number(x.costPerTray)+Number(x.transport||0)+Number(x.otherCosts||0);
  const profit=revenue-totalCost;
  const margin=revenue?profit/revenue*100:0;
  const totalEggs=Number(x.trays)*Number(x.eggsPerTray||30);
  const [r]=await pool.execute(
   `INSERT INTO calculations
   (customer,region,trays,eggs_per_tray,cost_per_tray,sell_per_tray,transport,other_costs,total_eggs,revenue,total_cost,profit,margin)
   VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)`,
   [x.customer||'Walk-in',x.region,Number(x.trays),Number(x.eggsPerTray||30),Number(x.costPerTray),Number(x.sellPerTray),Number(x.transport||0),Number(x.otherCosts||0),totalEggs,revenue,totalCost,profit,margin]
  );
  res.status(201).json({id:r.insertId,...x,totalEggs,revenue,totalCost,profit,margin});
 }catch(e){res.status(400).json({error:e.message})}
});

app.get('/api/calculations',async(req,res)=>{
 try{const [rows]=await pool.query('SELECT * FROM calculations ORDER BY created_at DESC LIMIT 200');res.json(rows)}
 catch(e){res.status(500).json({error:e.message})}
});

app.get('/api/dashboard',async(req,res)=>{
 try{
  const [[s]]=await pool.query(`SELECT COUNT(*) calculations,COALESCE(SUM(trays),0) trays,COALESCE(SUM(revenue),0) revenue,COALESCE(SUM(profit),0) profit FROM calculations`);
  res.json(s);
 }catch(e){res.status(500).json({error:e.message})}
});

const port=process.env.PORT||5000;
app.listen(port,()=>console.log(`YK Eggs API running on http://localhost:${port}`));
