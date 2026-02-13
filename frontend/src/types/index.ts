export interface SportType {
  id: number;
  code: string;
  label?: string;
  types?: ('individuel' | 'collectif')[];
}

export interface Championship {
  id?: number;
  name: string;
  competition?: Competition;
}

export interface Competition {
  id?: number;
  name: string;
  sport?: Sport;
  championships?: Championship[];
}

export interface Sport {
  id?: number;
  name: string;
  sportType: SportType;
  competitions?: Competition[];
}

export interface CreateSportDto {
  name: string;
  sportType: string; // IRI ou ID
}

export interface CreateCompetitionDto {
  name: string;
  sport: string; // IRI
}

export interface CreateChampionshipDto {
  name: string;
  competition: string; // IRI
}
