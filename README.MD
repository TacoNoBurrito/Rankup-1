![](https://i.ibb.co/7kqQ3Bz/Taco-1.png)

# A Simple Rankup Plugin
For PMMP 4.0

| Command | Usage |
| ------- | ----- |
 | /rankup (/ru) | Ascends through the ranks. |
 | /prestige (/pres) | Ascends through the prestiges. |

# Config

```yaml
# Messages
rankup: "You have ranked up to {rank}"
rankup-lack-money: "You need {money} to rank-up"
prestige: "You are now prestige {prestige}"
prestige-lack-money: "You need {money} to prestige"
max-rank: "You are at the max rank"
max-prestige: "You are at the max prestige"
need-be-max-to-prestige: "You must be the top rank to prestige!"
# Ranks
ranks:
  A:
    price: 1000
    commands:
      - "say {name} has ranked up to A"
  B:
    price: 2000
    commands:
      - "say {name} has ranked up to B"
# Prestige
prestiges:
  1:
    price: 10000
    commands:
      - "say {name} is now prestige 1"
```

# License

```text
Copyright (C) 2022  TacoError (xxTaylorTT)

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <https://www.gnu.org/licenses/>.
```
